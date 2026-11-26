<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Balaoan Cycle Parts</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="h-1.5 w-full flex">
        <div class="w-1/2 bg-[#009A44]"></div>
        <div class="w-1/4 bg-white"></div>
        <div class="w-1/4 bg-[#E30613]"></div>
    </div>

    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-10 w-auto object-contain">
                <div>
                    <span class="font-extrabold text-base text-slate-900 block leading-none">Balaoan <span class="text-[#009A44]">Cycle Parts</span></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#E30613]">My Rider Dashboard</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="/" class="text-xs sm:text-sm font-bold text-slate-700 hover:text-[#009A44] px-3 py-2 rounded-xl border border-slate-200">
                    &larr; Shop &amp; Book
                </a>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" class="bg-slate-900 hover:bg-[#E30613] text-white text-xs sm:text-sm font-bold px-4 py-2 rounded-xl transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Profile & Saved Bike (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white border border-slate-200 border-t-4 border-t-[#009A44] rounded-2xl p-6 shadow-sm">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#009A44]">Rider Profile</span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $user->name }}</h2>
                <p class="text-xs text-slate-500">{{ $user->email }}</p>

                @if(session('success'))
                    <div class="mt-4 bg-emerald-50 border border-[#009A44] text-[#007A36] px-3 py-2 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" class="mt-5 space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Saved Motorcycle</label>
                        <input type="text" name="motorcycle_model" value="{{ $user->motorcycle_model }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Plate Number</label>
                        <input type="text" name="plate_number" value="{{ $user->plate_number }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-[#009A44] hover:bg-[#007A36] text-white font-bold py-2.5 rounded-xl text-xs sm:text-sm transition">
                        Save Profile Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Orders & Bookings History (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Repair Bookings -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-extrabold text-slate-900">My Service Bay Bookings ({{ $bookings->count() }})</h3>
                <p class="text-xs text-slate-500 mb-4">Real-time status ng repair at installation slots mo.</p>

                @if($bookings->isEmpty())
                    <p class="text-sm text-slate-500 bg-slate-50 rounded-xl p-4">Wala ka pang repair booking. <a href="/#booking" class="text-[#E30613] font-bold underline">Book a slot now</a>.</p>
                @else
                    <div class="space-y-3">
                        @foreach($bookings as $b)
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400">{{ $b->scheduled_at->format('M d, Y • h:i A') }}</span>
                                    <h4 class="font-bold text-slate-900">{{ $b->service->name ?? 'Repair Service' }}</h4>
                                    <p class="text-xs text-slate-600">{{ $b->custom_motorcycle }} @if($b->plate_number) ({{ $b->plate_number }}) @endif</p>
                                </div>
                                <div class="sm:text-right">
                                    <span class="inline-block text-[11px] font-extrabold uppercase px-2.5 py-1 rounded-full {{ $b->status === 'completed' ? 'bg-[#009A44] text-white' : ($b->status === 'in_progress' ? 'bg-amber-400 text-slate-900' : 'bg-slate-200 text-slate-700') }}">
                                        {{ str_replace('_', ' ', $b->status) }}
                                    </span>
                                    <span class="block font-extrabold text-[#E30613] mt-1">&#8369;{{ number_format($b->total_amount, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Parts Orders -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-extrabold text-slate-900">My Parts Orders ({{ $sales->count() }})</h3>
                <p class="text-xs text-slate-500 mb-4">History ng mga biniling piyesa (Pickup o With Installation).</p>

                @if($sales->isEmpty())
                    <p class="text-sm text-slate-500 bg-slate-50 rounded-xl p-4">Wala ka pang parts order. <a href="/#parts" class="text-[#009A44] font-bold underline">Browse parts catalog</a>.</p>
                @else
                    <div class="space-y-3">
                        @foreach($sales as $sale)
                            <div class="border border-slate-200 rounded-xl p-4">
                                <div class="flex items-center justify-between border-b border-slate-100 pb-2 mb-2">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-900">{{ $sale->invoice_number }}</span>
                                        <span class="text-xs text-slate-400 ml-2">{{ $sale->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="text-[11px] font-extrabold uppercase px-2.5 py-0.5 rounded-full {{ $sale->status === 'completed' ? 'bg-emerald-100 text-[#009A44]' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $sale->status }}
                                    </span>
                                </div>
                                <ul class="text-xs text-slate-600 space-y-1">
                                    @foreach($sale->items as $item)
                                        <li>{{ $item->quantity }}x {{ $item->part->name ?? 'Part' }} &mdash; &#8369;{{ number_format($item->subtotal, 2) }}</li>
                                    @endforeach
                                </ul>
                                <div class="mt-2 pt-2 border-t border-slate-100 flex justify-between items-center text-xs">
                                    <span class="uppercase font-bold text-slate-400">{{ str_replace('_', ' ', $sale->order_type ?? 'pickup') }} &bull; {{ strtoupper($sale->payment_method) }}</span>
                                    <span class="font-extrabold text-base text-[#E30613]">&#8369;{{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>