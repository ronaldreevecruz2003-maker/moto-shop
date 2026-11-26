<?php

namespace App\Http\Controllers;

use App\Models\RepairBooking;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('cart_success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Mali ang email o password na inilagay mo.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.customer-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:50',
            'motorcycle_model' => 'required|string|max:255',
            'plate_number' => 'nullable|string|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'motorcycle_model' => $validated['motorcycle_model'],
            'plate_number' => $validated['plate_number'] ?? null,
            'role' => 'customer',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('cart_success', 'Account created! Pwede ka nang mag-order ng parts at mag-book ng repair slot.');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $sales = Sale::with('items.part')
            ->where(function ($q) use ($user) {
                if ($user->phone) {
                    $q->where('customer_phone', $user->phone);
                }
                $q->orWhere('customer_name', $user->name);
            })
            ->latest()
            ->get();

        $bookings = RepairBooking::with(['service', 'motorcycleModel'])
            ->where(function ($q) use ($user) {
                if ($user->phone) {
                    $q->where('customer_phone', $user->phone);
                }
                $q->orWhere('customer_name', $user->name);
            })
            ->latest('scheduled_at')
            ->get();

        return view('auth.customer-dashboard', compact('user', 'sales', 'bookings'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'motorcycle_model' => 'required|string|max:255',
            'plate_number' => 'nullable|string|max:50',
        ]);

        $user->update($validated);

        return back()->with('success', 'Na-update na ang profile at motorcycle details mo!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('cart_success', 'Naka-logout ka na sa account mo.');
    }
}