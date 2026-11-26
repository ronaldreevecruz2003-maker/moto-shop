<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MotorcycleModel;
use App\Models\Part;
use App\Models\RepairBooking;
use App\Models\Review;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorefrontController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['parts' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get();
        $models = MotorcycleModel::orderBy('brand')->orderBy('name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        $partsQuery = Part::with(['category', 'compatibleModels'])
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $partsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $partsQuery->where('category_id', $request->category);
        }

        if ($request->filled('model')) {
            $partsQuery->whereHas('compatibleModels', function ($q) use ($request) {
                $q->where('motorcycle_models.id', $request->model);
            });
        }

        $parts = $partsQuery->latest()->get();
        $allPartsForReview = Part::where('is_active', true)->orderBy('name')->get();

        $reviews = Review::with('part')
            ->where('is_approved', true)
            ->latest()
            ->get();

        $trackedBookings = collect();
        if ($request->filled('track')) {
            $track = trim($request->track);
            $trackedBookings = RepairBooking::with(['service', 'motorcycleModel'])
                ->where('customer_phone', 'like', "%{$track}%")
                ->orWhere('plate_number', 'like', "%{$track}%")
                ->latest('scheduled_at')
                ->take(5)
                ->get();
        }

        return view('storefront', compact(
            'categories',
            'models',
            'services',
            'parts',
            'allPartsForReview',
            'reviews',
            'trackedBookings'
        ));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'motorcycle_model' => 'nullable|string|max:255',
            'type' => 'required|in:mechanic,product',
            'part_id' => 'nullable|exists:parts,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validated['type'] === 'mechanic') {
            $validated['part_id'] = null;
        }

        $validated['is_approved'] = false;
        Review::create($validated);

        return redirect('/#reviews')->with('review_success', 'Salamat sa review mo! Ipapakita ito sa website pagkatapos ma-verify ng admin.');
    }

    public function checkoutCart(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'order_type' => 'required|in:pickup_only,with_installation',
            'payment_method' => 'required|in:cash,gcash',
            'cart_json' => 'required|string',
            'custom_motorcycle' => 'required_if:order_type,with_installation|nullable|string|max:255',
            'plate_number' => 'nullable|string|max:50',
            'service_id' => 'required_if:order_type,with_installation|nullable|exists:services,id',
            'scheduled_at' => 'required_if:order_type,with_installation|nullable|date|after:now',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = json_decode($validated['cart_json'], true);
        if (!is_array($cartItems) || empty($cartItems)) {
            return back()->withErrors(['cart' => 'Walang laman ang cart mo. Mag-add to cart muna ng piyesa.']);
        }

        $invoice = 'BCP-' . now()->format('Ymd-His');

        DB::transaction(function () use ($validated, $cartItems, $invoice) {
            $grandTotal = 0;
            $preparedItems = [];

            foreach ($cartItems as $item) {
                $part = Part::lockForUpdate()->findOrFail($item['id']);
                $qty = max(1, min((int) $item['qty'], $part->stock_quantity));
                if ($part->stock_quantity < $qty) {
                    throw new \RuntimeException("Kulang na ang stock para sa {$part->name}.");
                }
                $subtotal = $part->price * $qty;
                $grandTotal += $subtotal;
                $preparedItems[] = [
                    'part' => $part,
                    'qty' => $qty,
                    'price' => $part->price,
                    'subtotal' => $subtotal,
                ];
            }

            $sale = Sale::create([
                'invoice_number' => $invoice,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'payment_method' => $validated['payment_method'],
                'order_type' => $validated['order_type'],
                'status' => 'pending',
                'total_amount' => $grandTotal,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($preparedItems as $p) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'part_id' => $p['part']->id,
                    'quantity' => $p['qty'],
                    'unit_price' => $p['price'],
                    'subtotal' => $p['subtotal'],
                ]);
            }

            if ($validated['order_type'] === 'with_installation') {
                $service = Service::findOrFail($validated['service_id']);
                $partsListSummary = collect($preparedItems)
                    ->map(fn ($p) => "{$p['qty']}x {$p['part']->name}")
                    ->implode(', ');

                RepairBooking::create([
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'custom_motorcycle' => $validated['custom_motorcycle'],
                    'plate_number' => $validated['plate_number'] ?? null,
                    'service_id' => $service->id,
                    'scheduled_at' => $validated['scheduled_at'],
                    'status' => 'pending',
                    'total_amount' => $service->labor_price + $grandTotal,
                    'mechanic_notes' => "Order #{$invoice} | Parts: {$partsListSummary}" . (!empty($validated['notes']) ? " | Notes: {$validated['notes']}" : ''),
                ]);
            }
        });

        $msg = $validated['order_type'] === 'with_installation'
            ? "Order #{$invoice} & Installation Booking confirmed! Nakareserba na ang piyesa at slot mo."
            : "Order #{$invoice} confirmed! Nakareserba na ang piyesa mo para sa pickup sa Balaoan Cycle Parts.";

        return redirect('/')->with('cart_success', $msg);
    }

    public function bookRepair(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'custom_motorcycle' => 'required|string|max:255',
            'plate_number' => 'nullable|string|max:50',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'mechanic_notes' => 'nullable|string|max:1000',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $validated['status'] = 'pending';
        $validated['total_amount'] = $service->labor_price;

        RepairBooking::create($validated);

        return redirect('/#booking')->with('success', 'Na-submit na ang booking mo! Maghintay ng text/tawag mula sa Balaoan Cycle Parts.');
    }
}
