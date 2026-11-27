<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(): View
    {
        $parts = Part::with(['category', 'compatibleModels'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('parts'));
    }

    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:120',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:Cash,GCash',
            'gcash_reference' => 'nullable|string|max:100',
            'amount_tendered' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.part_id' => 'required|exists:parts,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validated['payment_method'] === 'GCash' && empty(trim($validated['gcash_reference'] ?? ''))) {
            return response()->json(['message' => 'GCash reference number is required.'], 422);
        }

        try {
            $sale = DB::transaction(function () use ($validated) {
                $subtotal = 0;
                $totalCost = 0;
                $lineItems = [];

                foreach ($validated['items'] as $entry) {
                    $part = Part::lockForUpdate()->findOrFail($entry['part_id']);
                    $qty = (int) $entry['quantity'];

                    if ($part->stock_quantity < $qty) {
                        throw new \RuntimeException("Insufficient stock for {$part->name} (Available: {$part->stock_quantity}).");
                    }

                    $unitPrice = (float) $part->price;
                    $costPrice = (float) ($part->cost_price ?? 0);
                    $lineSubtotal = $unitPrice * $qty;
                    $lineCost = $costPrice * $qty;

                    $subtotal += $lineSubtotal;
                    $totalCost += $lineCost;

                    $lineItems[] = [
                        'part' => $part,
                        'quantity' => $qty,
                        'cost_price' => $costPrice,
                        'unit_price' => $unitPrice,
                        'subtotal' => $lineSubtotal,
                    ];
                }

                $discount = min((float) ($validated['discount'] ?? 0), $subtotal);
                $totalAmount = max(0, $subtotal - $discount);
                $amountTendered = (float) $validated['amount_tendered'];

                if ($amountTendered < $totalAmount) {
                    throw new \RuntimeException('Amount tendered cannot be less than the total amount.');
                }

                $changeAmount = $validated['payment_method'] === 'Cash'
                    ? max(0, $amountTendered - $totalAmount)
                    : 0;

                $sale = Sale::create([
                    'invoice_number' => 'INV-' . now()->format('Ymd-His') . '-' . rand(10, 99),
                    'user_id' => auth()->id(),
                    'customer_name' => trim($validated['customer_name'] ?? '') ?: 'Walk-In Customer',
                    'order_type' => 'walk_in',
                    'status' => 'completed',
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total_amount' => $totalAmount,
                    'total_profit' => $totalAmount - $totalCost,
                    'payment_method' => $validated['payment_method'],
                    'gcash_reference' => $validated['payment_method'] === 'GCash' ? trim($validated['gcash_reference']) : null,
                    'amount_tendered' => $amountTendered,
                    'change_amount' => $changeAmount,
                ]);

                // Note: SaleItem::created automatically decrements stock_quantity once
                foreach ($lineItems as $item) {
                    $sale->items()->create([
                        'part_id' => $item['part']->id,
                        'quantity' => $item['quantity'],
                        'cost_price' => $item['cost_price'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                return $sale;
            });

            return response()->json([
                'message' => 'Sale completed!',
                'receipt_url' => route('pos.receipt', $sale),
            ]);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function receipt(Sale $sale): View
    {
        $sale->load(['items.part', 'user']);

        return view('pos.receipt', compact('sale'));
    }
}