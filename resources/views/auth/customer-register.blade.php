<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer Account | Balaoan Cycle Parts</title>
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

    <div class="max-w-lg w-full mx-auto px-4 py-10">
        <div class="text-center mb-6">
            <a href="/" class="inline-flex flex-col items-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Balaoan Cycle Parts" class="h-14 w-auto object-contain rounded-xl shadow-sm bg-white p-1.5">
                <span class="font-extrabold text-lg text-slate-900 mt-2">Balaoan <span class="text-[#009A44]">Cycle Parts</span></span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 border-t-4 border-t-[#E30613] rounded-2xl p-6 sm:p-8 shadow-lg">
            <h1 class="text-2xl font-extrabold text-slate-900">Create Rider Account</h1>
            <p class="text-xs text-slate-500 mt-1 mb-6">Mag-register para sa mas mabilis na checkout, repair booking, at live tracking ng motor mo.</p>

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-[#E30613] px-3.5 py-2.5 rounded-xl text-xs font-semibold">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.register.post') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Juan Dela Cruz"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="09XX-XXX-XXXX"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="rider@example.com"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Motorcycle Model *</label>
                        <input type="text" name="motorcycle_model" value="{{ old('motorcycle_model') }}" required placeholder="e.g., Yamaha NMAX 155"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Plate Number</label>
                        <input type="text" name="plate_number" value="{{ old('plate_number') }}" placeholder="Optional"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Password (min 6 chars) *</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#E30613] hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow transition text-sm">
                    Register Account
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <a href="/" class="hover:text-slate-900 font-semibold">&larr; Back to Store</a>
                <span>May account na? <a href="{{ route('customer.login') }}" class="font-extrabold text-[#009A44] hover:underline">Login Here</a></span>
            </div>
        </div>
    </div>

    <div class="text-center py-4 text-xs text-slate-400">
        &copy; {{ date('Y') }} Balaoan Cycle Parts
    </div>
</body>
</html>