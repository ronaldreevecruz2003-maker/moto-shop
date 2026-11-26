<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login | Balaoan Cycle Parts</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col justify-between">
    <div class="h-1.5 w-full flex">
        <div class="w-1/2 bg-[#009A44]"></div>
        <div class="w-1/4 bg-white"></div>
        <div class="w-1/4 bg-[#E30613]"></div>
    </div>

    <div class="max-w-md w-full mx-auto px-4 py-12">
        <div class="text-center mb-6">
            <a href="/" class="inline-flex flex-col items-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Balaoan Cycle Parts" class="h-16 w-auto object-contain rounded-xl shadow-sm bg-white p-1.5">
                <span class="font-extrabold text-xl text-slate-900 mt-3">Balaoan <span class="text-[#009A44]">Cycle Parts</span></span>
                <span class="text-xs font-bold uppercase tracking-widest text-[#E30613]">Customer Portal</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 border-t-4 border-t-[#009A44] rounded-2xl p-6 sm:p-8 shadow-lg">
            <h1 class="text-2xl font-extrabold text-slate-900">Sign In to Your Account</h1>
            <p class="text-xs text-slate-500 mt-1 mb-6">Mag-login para makapag-checkout ng parts, mag-book ng repair, at makita ang status ng motor mo.</p>

            @if(session('auth_notice'))
                <div class="mb-4 bg-amber-50 border border-amber-300 text-amber-800 px-3.5 py-2.5 rounded-xl text-xs font-semibold">
                    {{ session('auth_notice') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-[#E30613] px-3.5 py-2.5 rounded-xl text-xs font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="rider@example.com"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="inline-flex items-center gap-2 text-slate-600 font-medium cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#009A44]">
                        <span>Remember me</span>
                    </label>
                    <a href="/" class="text-slate-500 hover:text-slate-800 font-semibold">&larr; Back to Storefront</a>
                </div>

                <button type="submit" class="w-full bg-[#009A44] hover:bg-[#007A36] text-white font-bold py-3 rounded-xl shadow transition text-sm">
                    Login
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
                Wala pang customer account?
                <a href="{{ route('customer.register') }}" class="font-extrabold text-[#E30613] hover:underline ml-1">Create Account Now &rarr;</a>
            </div>
        </div>
    </div>

    <div class="text-center py-4 text-xs text-slate-400">
        &copy; {{ date('Y') }} Balaoan Cycle Parts
    </div>
</body>
</html>