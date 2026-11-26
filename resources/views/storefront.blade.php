<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balaoan Cycle Parts | Performance Parts &amp; Service Bay</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .racing-grid {
            background-image: radial-gradient(rgba(255, 255, 255, 0.14) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body data-logged-in="{{ auth()->check() ? '1' : '0' }}" class="bg-slate-50 text-slate-900 antialiased selection:bg-[#009A44] selection:text-white">

    <!-- Top Utility & Racing Bar -->
    <div class="bg-slate-950 text-slate-300 text-[11px] font-medium border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-white font-semibold">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#009A44] animate-pulse"></span>
                    Balaoan, La Union
                </span>
                <span class="hidden sm:inline text-slate-600">|</span>
                <span class="hidden sm:inline">Mon &ndash; Sat: 8:00 AM &ndash; 5:30 PM</span>
            </div>
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="#tracker" class="hover:text-white transition">Check Repair Status</a>
                <span class="text-slate-700">|</span>
                @auth
                    <a href="{{ route('customer.dashboard') }}" class="text-emerald-400 hover:text-white font-bold transition">Hi, {{ Auth::user()->name }} (My Account)</a>
                @else
                    <a href="{{ route('customer.login') }}" class="text-white hover:text-[#009A44] font-bold transition">Login</a>
                    <span class="text-slate-700">/</span>
                    <a href="{{ route('customer.register') }}" class="text-[#E30613] hover:text-red-400 font-bold transition">Sign Up</a>
                @endauth

            </div>
        </div>
    </div>

    <!-- Castrol Racing Livery Accent Line -->
    <div class="h-1 w-full flex">
        <div class="w-1/2 bg-[#009A44]"></div>
        <div class="w-1/4 bg-white"></div>
        <div class="w-1/4 bg-[#E30613]"></div>
    </div>

    <!-- Main Sticky Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.jpg') }}" alt="Balaoan Cycle Parts Logo"
                    class="h-12 w-auto object-contain group-hover:scale-105 transition">
                <div class="hidden sm:block border-l border-slate-200 pl-3">
                    <span class="font-extrabold text-base tracking-tight text-slate-900 block leading-none">
                        Balaoan <span class="text-[#009A44]">Cycle Parts</span>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#E30613] block mt-1">
                        Parts &amp; Performance Bay
                    </span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-600">
                <a href="#parts" class="hover:text-[#009A44] transition">Parts Catalog</a>
                <a href="#services" class="hover:text-[#009A44] transition">Service Menu</a>
                <a href="#tracker" class="hover:text-[#009A44] transition">Live Bay Tracker</a>
                <a href="#booking" class="hover:text-[#009A44] transition">Book Appointment</a>
                <a href="#reviews" class="hover:text-[#009A44] transition">Reviews</a>
                <a href="#reviews" class="hover:text-[#009A44] transition">Reviews</a>
            </nav>

            <div class="flex items-center gap-2.5">
                <button onclick="openCartDrawer()"
                    class="relative inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition">
                    <svg class="w-4 h-4 text-[#009A44]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                    <span>Cart</span>
                    <span id="cartBadge" class="bg-[#E30613] text-white text-[11px] font-extrabold px-2 py-0.5 rounded-full">0</span>
                </button>

                <a href="#booking"
                    class="hidden sm:inline-flex items-center gap-1.5 bg-[#E30613] hover:bg-red-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition">
                    <span>Book Service</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Alerts -->
    @if(session('cart_success'))
        <div id="checkoutAlert" class="bg-[#009A44] text-white border-b-2 border-[#E30613]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5 text-sm font-bold">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('cart_success') }}</span>
                </div>
                <button onclick="document.getElementById('checkoutAlert').remove()" class="text-white/80 hover:text-white font-black text-lg">&times;</button>
            </div>
        </div>
        <script>localStorage.removeItem('bcp_cart');</script>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-b border-red-200 text-[#E30613]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-xs sm:text-sm font-semibold">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#008C3E] via-[#006B2F] to-slate-950 text-white border-b-4 border-[#E30613]">
        <div class="absolute inset-0 racing-grid opacity-60"></div>
        <div class="hidden lg:block absolute -right-24 top-0 h-full w-80 bg-[#E30613] -skew-x-12 shadow-2xl"></div>
        <div class="hidden lg:block absolute right-52 top-0 h-full w-6 bg-white -skew-x-12"></div>
        <div class="hidden lg:block absolute right-60 top-0 h-full w-2 bg-[#009A44] -skew-x-12"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 text-white text-xs font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-5">
                    <span class="h-2 w-2 rounded-full bg-[#E30613]"></span>
                    Official Parts &amp; Service Center &bull; Balaoan
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-extrabold tracking-tight leading-[1.12]">
                    Precision Parts &amp; <span class="text-emerald-300">Expert Moto Care.</span>
                </h1>
                <p class="mt-5 text-slate-200 text-base sm:text-lg leading-relaxed max-w-xl">
                    Mag-order ng genuine at racing motorcycle parts para sa same-day pickup, o i-book kasama ang professional installation ng aming mga mekaniko.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3.5">
                    <a href="#parts" class="inline-flex items-center gap-2 bg-[#E30613] hover:bg-red-700 text-white font-bold px-6 py-3.5 rounded-xl shadow-lg shadow-red-950/30 transition text-sm">
                        <span>Browse Parts Catalog</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#booking" class="inline-flex items-center gap-2 bg-white hover:bg-slate-100 text-slate-900 font-bold px-6 py-3.5 rounded-xl shadow-lg transition text-sm">
                        <span>Schedule Repair Slot</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust & Value Props Bar -->
    <section class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 rounded-xl bg-emerald-50 text-[#009A44] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Trusted Brands</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Castrol, JVT, RCB, &amp; OEM parts.</p>
                </div>
            </div>
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 rounded-xl bg-red-50 text-[#E30613] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Buy + Install Option</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Diretso kabit pagdating sa bay.</p>
                </div>
            </div>
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 rounded-xl bg-emerald-50 text-[#009A44] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Live Repair Tracking</h3>
                    <p class="text-xs text-slate-500 mt-0.5">I-monitor kung tapos na ang motor.</p>
                </div>
            </div>
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 rounded-xl bg-red-50 text-[#E30613] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Transparent Pricing</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Walang hidden charges sa parts at labor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Repair Status Tracker -->
    <section id="tracker" class="bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-slate-800/70 border border-slate-700/80 rounded-2xl p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div class="flex items-start gap-3.5">
                    <div class="h-10 w-10 rounded-xl bg-[#009A44]/20 border border-[#009A44]/40 text-[#009A44] flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <div>
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-400">Service Bay Live Tracker</span>
                        <h2 class="text-lg sm:text-xl font-extrabold text-white">I-check ang status ng motor mo</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Ilagay ang Plate Number o Mobile Number na ginamit sa pag-book.</p>
                    </div>
                </div>
                <form method="GET" action="/#tracker" class="flex flex-col sm:flex-row gap-2.5 w-full lg:w-auto">
                    <input type="text" name="track" value="{{ request('track') }}" placeholder="e.g., 123-ABC or 0917..."
                        class="bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-[#009A44] sm:w-64">
                    <button type="submit" class="bg-[#009A44] hover:bg-[#007A36] text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow transition">
                        Track Status
                    </button>
                </form>
            </div>

            @if(request()->filled('track'))
                <div class="mt-5">
                    @if($trackedBookings->isEmpty())
                        <div class="text-sm text-slate-300 bg-slate-800/90 border border-slate-700 rounded-xl px-5 py-4">
                            Walang nahanap na record para sa "<span class="text-white font-bold">{{ request('track') }}</span>". Siguraduhing tama ang plate number o mobile number.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($trackedBookings as $booking)
                                <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 flex items-center justify-between gap-4">
                                    <div>
                                        <span class="text-xs font-semibold text-slate-400">{{ $booking->scheduled_at->format('M d, Y') }} &bull; {{ $booking->scheduled_at->format('h:i A') }}</span>
                                        <h3 class="font-extrabold text-white text-base mt-0.5">{{ $booking->service->name ?? 'Repair Service' }}</h3>
                                        <p class="text-xs text-slate-300 mt-1">
                                            {{ $booking->customer_name }} &bull;
                                            <span class="text-emerald-400 font-semibold">{{ $booking->custom_motorcycle ?: ($booking->motorcycleModel ? $booking->motorcycleModel->brand . ' ' . $booking->motorcycleModel->name : 'Motorcycle') }}</span>
                                            @if($booking->plate_number) ({{ $booking->plate_number }}) @endif
                                        </p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        @php
                                            $badge = match($booking->status) {
                                                'completed' => 'bg-[#009A44] text-white',
                                                'in_progress' => 'bg-amber-400 text-slate-950',
                                                'cancelled' => 'bg-[#E30613] text-white',
                                                default => 'bg-slate-700 text-slate-200',
                                            };
                                            $label = match($booking->status) {
                                                'completed' => 'READY FOR PICKUP',
                                                'in_progress' => 'GINAGAWA NA',
                                                'cancelled' => 'CANCELLED',
                                                default => 'PENDING QUEUE',
                                            };
                                        @endphp
                                        <span class="inline-block text-[11px] font-extrabold px-3 py-1 rounded-full tracking-wide {{ $badge }}">
                                            {{ $label }}
                                        </span>
                                        <span class="block text-base font-extrabold text-white mt-1.5">&#8369;{{ number_format($booking->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Parts Catalog Section -->
    <section id="parts" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-6">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-[#E30613] mb-1">
                    <span class="h-1.5 w-4 bg-[#E30613] rounded-full"></span>
                    Catalog &amp; Inventory
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Parts &amp; Accessories</h2>
                <p class="text-slate-500 text-sm mt-1">Piliin kung bibilhin lang (Pickup) o ipapakabit sa shop (Buy + Install).</p>
            </div>

            <!-- Search & Model Filter -->
            <form method="GET" action="/#parts" class="flex flex-wrap items-center gap-2.5">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative flex-1 sm:flex-initial">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search part, brand, SKU..."
                        class="w-full sm:w-56 bg-white border border-slate-300 rounded-xl pl-3.5 pr-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#009A44] focus:ring-2 focus:ring-[#009A44]/20">
                </div>

                <select name="model" class="bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-700 font-medium focus:outline-none focus:border-[#009A44]">
                    <option value="">All Motorcycles</option>
                    @foreach($models as $model)
                        <option value="{{ $model->id }}" @selected(request('model') == $model->id)>{{ $model->brand }} {{ $model->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-[#009A44] hover:bg-[#007A36] text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-sm transition">
                    Search
                </button>
                @if(request()->hasAny(['search', 'category', 'model']))
                    <a href="/#parts" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-4 py-2.5 rounded-xl text-sm transition">Clear</a>
                @endif
            </form>
        </div>

        <!-- Quick Category Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6 border-b border-slate-200">
            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}#parts"
                class="shrink-0 px-4 py-1.5 rounded-full text-xs font-bold transition {{ !request('category') ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-[#009A44]' }}">
                All Items
            </a>
            @foreach($categories as $category)
                <a href="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}#parts"
                    class="shrink-0 px-4 py-1.5 rounded-full text-xs font-bold transition {{ request('category') == $category->id ? 'bg-[#009A44] text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-[#009A44]' }}">
                    {{ $category->name }} <span class="ml-1 opacity-75">({{ $category->parts_count ?? 0 }})</span>
                </a>
            @endforeach
        </div>

        @if($parts->isEmpty())
            <div class="bg-white border border-slate-200 rounded-2xl p-14 text-center shadow-sm">
                <p class="text-slate-600 font-semibold">Walang nahanap na piyesa na tugma sa filter mo.</p>
                <a href="/#parts" class="inline-block mt-3 text-xs font-bold text-[#E30613] hover:underline">Ipakita lahat ng piyesa &rarr;</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($parts as $part)
                    @php
                        $partData = [
                            'id' => $part->id,
                            'name' => $part->name,
                            'brand' => $part->brand ?? 'Generic',
                            'sku' => $part->sku,
                            'category' => $part->category->name ?? 'General',
                            'price' => (float) $part->price,
                            'priceFormatted' => 'Ã¢â€šÂ±' . number_format($part->price, 2),
                            'stock' => (int) $part->stock_quantity,
                            'description' => $part->description ?: 'Available sa Balaoan Cycle Parts.',
                            'image' => $part->image ? asset('storage/' . $part->image) : null,
                            'bikes' => $part->compatibleModels->map(fn($b) => $b->brand . ' ' . $b->name)->values(),
                        ];
                    @endphp
                    <div class="group bg-white border border-slate-200/90 rounded-2xl overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-[#009A44] transition-all duration-200">
                        <div data-part='@json($partData)' onclick="openPartModal(JSON.parse(this.dataset.part))" class="cursor-pointer">
                            <div class="aspect-[4/3] bg-slate-100 relative overflow-hidden border-b border-slate-100">
                                @if($part->image)
                                    <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200/70 p-4 text-center">
                                        <span class="text-xs font-extrabold uppercase tracking-widest text-[#009A44]">{{ $part->brand ?? 'BCP' }}</span>
                                        <span class="text-[11px] text-slate-400 mt-1">Click to inspect</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 bg-slate-900/85 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">
                                    {{ $part->category->name ?? 'General' }}
                                </span>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <span>{{ $part->brand ?? 'Generic' }}</span>
                                    <span>{{ $part->sku }}</span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base mt-1 line-clamp-2 group-hover:text-[#009A44] transition">
                                    {{ $part->name }}
                                </h3>
                                @if($part->compatibleModels->isNotEmpty())
                                    <div class="mt-2.5 flex flex-wrap gap-1">
                                        @foreach($part->compatibleModels->take(3) as $bike)
                                            <span class="text-[10px] font-bold bg-emerald-50 text-[#009A44] px-2 py-0.5 rounded-md">
                                                {{ $bike->brand }} {{ $bike->name }}
                                            </span>
                                        @endforeach
                                        @if($part->compatibleModels->count() > 3)
                                            <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md">
                                                +{{ $part->compatibleModels->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="px-4 pb-4 pt-3 border-t border-slate-100 bg-slate-50/50 space-y-3">
                            <div class="flex items-baseline justify-between">
                                <span class="text-xl font-extrabold text-[#E30613]">&#8369;{{ number_format($part->price, 2) }}</span>
                                @if($part->stock_quantity > 0)
                                    <span class="text-[11px] font-bold text-[#009A44] bg-emerald-50 px-2 py-0.5 rounded-full">
                                        {{ $part->stock_quantity }} in stock
                                    </span>
                                @else
                                    <span class="text-[11px] font-bold text-[#E30613] bg-red-50 px-2 py-0.5 rounded-full">
                                        Sold out
                                    </span>
                                @endif
                            </div>

                            @if($part->stock_quantity > 0)
                                @auth
                                    <div class="grid grid-cols-2 gap-2">
                                        <button type="button" data-part='@json($partData)'
                                            onclick="addToCart(JSON.parse(this.dataset.part), 'pickup_only', false)"
                                            class="bg-white hover:bg-[#009A44] text-[#009A44] hover:text-white border border-[#009A44] font-bold py-2 px-2 rounded-xl text-xs transition">
                                            + Add to Cart
                                        </button>
                                        <button type="button" data-part='@json($partData)'
                                            onclick="addToCart(JSON.parse(this.dataset.part), 'with_installation', true)"
                                            class="bg-[#E30613] hover:bg-red-700 text-white font-bold py-2 px-2 rounded-xl text-xs shadow-sm transition">
                                            Buy + Install
                                        </button>
                                    </div>
                                @else
                                    <a href="{{ route('customer.login') }}"
                                        class="block text-center w-full bg-slate-900 hover:bg-[#009A44] text-white font-bold py-2.5 px-3 rounded-xl text-xs transition">
                                        Login / Sign Up to Order
                                    </a>
                                @endauth
                            @else
                                <button disabled class="w-full bg-slate-100 text-slate-400 font-bold py-2 rounded-xl text-xs cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Services & Standalone Repair Booking -->
    <section id="services" class="bg-white border-t border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Service Menu (7 cols) -->
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-[#009A44] mb-1">
                    <span class="h-1.5 w-4 bg-[#009A44] rounded-full"></span>
                    Workshop Rates
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Repair &amp; Maintenance Menu</h2>
                <p class="text-slate-500 text-sm mt-1 mb-6">Standardized labor pricing mula sa mga mekaniko ng Balaoan Cycle Parts.</p>

                <div class="space-y-3.5">
                    @foreach($services as $service)
                        <div class="bg-slate-50 hover:bg-white border border-slate-200 hover:border-[#009A44] rounded-2xl p-5 flex items-start justify-between gap-4 transition shadow-sm">
                            <div>
                                <div class="flex items-center gap-2.5">
                                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">{{ $service->name }}</h3>
                                    <span class="text-[11px] font-bold text-[#009A44] bg-emerald-100/80 px-2.5 py-0.5 rounded-full">
                                        ~{{ $service->estimated_minutes }} mins
                                    </span>
                                </div>
                                @if($service->description)
                                    <p class="text-slate-600 text-sm mt-1.5 leading-relaxed">{{ $service->description }}</p>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-xl font-extrabold text-[#E30613]">&#8369;{{ number_format($service->labor_price, 2) }}</span>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Labor Fee</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Booking Form (5 cols) -->
            <div id="booking" class="lg:col-span-5">
                <div class="bg-slate-50 border border-slate-200 border-t-4 border-t-[#E30613] rounded-2xl p-6 sm:p-8 shadow-sm sticky top-24">
                    <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#E30613]">Service Appointment</span>
                    <h2 class="text-2xl font-extrabold text-slate-900 mt-0.5">Book a Repair Slot</h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1 mb-6">Para sa change oil, tune-up, o general checkup.</p>

                    @if(session('success'))
                        <div class="mb-5 bg-emerald-50 border border-[#009A44] text-[#007A36] font-semibold px-4 py-3 rounded-xl text-xs sm:text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('book.repair') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                                <input type="text" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required placeholder="Juan Dela Cruz"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number *</label>
                                <input type="text" name="customer_phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="09XX-XXX-XXXX" required
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Motorcycle Model *</label>
                                <input type="text" name="custom_motorcycle" value="{{ auth()->user()->motorcycle_model ?? '' }}" placeholder="e.g., Yamaha NMAX 155" required
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Plate Number</label>
                                <input type="text" name="plate_number" value="{{ auth()->user()->plate_number ?? '' }}" placeholder="Optional"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Service Needed *</label>
                                <select name="service_id" required class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                                    <option value="">-- Choose Service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }} (&#8369;{{ number_format($service->labor_price, 2) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Preferred Schedule *</label>
                                <input type="datetime-local" name="scheduled_at" required
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Notes for Mechanic</label>
                            <textarea name="mechanic_notes" rows="2" placeholder="Ilarawan ang issue ng motor..."
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#E30613] hover:bg-red-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">
                            Confirm Service Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews Section (Mechanics & Products) -->
    <section id="reviews" class="bg-slate-50 border-t border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-[#009A44] mb-1">
                        <span class="h-1.5 w-4 bg-[#009A44] rounded-full"></span>
                        Rider Feedback &amp; Ratings
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mechanic &amp; Product Reviews</h2>
                    <p class="text-slate-500 text-sm mt-1">Mga totoong karanasan ng mga rider sa Balaoan Cycle Parts service bay at piyesa.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="filterReviews('all')" id="revTabAll"
                        class="rev-tab bg-slate-900 text-white px-4 py-2 rounded-full text-xs font-bold transition">
                        All Reviews ({{ $reviews->count() }})
                    </button>
                    <button type="button" onclick="filterReviews('mechanic')" id="revTabMechanic"
                        class="rev-tab bg-white border border-slate-200 text-slate-600 hover:border-[#009A44] px-4 py-2 rounded-full text-xs font-bold transition">
                        Mechanics &amp; Bay ({{ $reviews->where('type', 'mechanic')->count() }})
                    </button>
                    <button type="button" onclick="filterReviews('product')" id="revTabProduct"
                        class="rev-tab bg-white border border-slate-200 text-slate-600 hover:border-[#E30613] px-4 py-2 rounded-full text-xs font-bold transition">
                        Parts &amp; Products ({{ $reviews->where('type', 'product')->count() }})
                    </button>
                </div>
            </div>

            @if(session('review_success'))
                <div class="mb-8 bg-emerald-50 border border-[#009A44] text-[#007A36] font-semibold px-4 py-3 rounded-xl text-sm">
                    {{ session('review_success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Reviews Feed (8 cols) -->
                <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-4 content-start">
                    @foreach($reviews as $rev)
                        <div data-rev-type="{{ $rev->type }}" class="review-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    @if($rev->type === 'mechanic')
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-[#009A44] border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                            Mechanic &amp; Service Bay
                                        </span>
                                    @else
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-red-50 text-[#E30613] border border-red-200 px-2.5 py-0.5 rounded-full">
                                            Product Review
                                        </span>
                                    @endif

                                    <div class="flex items-center text-amber-400 text-sm tracking-tight" aria-label="{{ $rev->rating }} out of 5 stars">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span>{{ $s <= $rev->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>

                                @if($rev->type === 'product' && $rev->part)
                                    <p class="text-xs font-extrabold text-slate-900 mb-1.5">
                                        Part: <span class="text-[#E30613]">{{ $rev->part->name }}</span>
                                    </p>
                                @endif

                                <p class="text-sm text-slate-600 leading-relaxed">"{{ $rev->comment }}"</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-extrabold text-slate-900">{{ $rev->customer_name }}</p>
                                    @if($rev->motorcycle_model)
                                        <p class="text-[11px] font-semibold text-slate-400">{{ $rev->motorcycle_model }}</p>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Leave a Review Form (4 cols) -->
                <div class="lg:col-span-4">
                    <div class="bg-white border border-slate-200 border-t-4 border-t-[#009A44] rounded-2xl p-6 shadow-sm sticky top-24">
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#009A44]">Share Your Experience</span>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">Write a Review</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-5">I-rate ang serbisyo ng mekaniko o ang piyesang nabili mo.</p>

                        <form method="POST" action="{{ route('reviews.store') }}" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">What are you reviewing? *</label>
                                <select name="type" id="reviewTypeSelect" onchange="toggleReviewPartSelect()"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                                    <option value="mechanic">Mechanic &amp; Repair Service</option>
                                    <option value="product">Motorcycle Part / Product</option>
                                </select>
                            </div>

                            <div id="reviewPartWrapper" class="hidden">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Select Part / Product</label>
                                <select name="part_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                                    <option value="">-- Choose Part --</option>
                                    @foreach($allPartsForReview as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Your Name *</label>
                                    <input type="text" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required placeholder="e.g., Juan D."
                                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Motorcycle</label>
                                    <input type="text" name="motorcycle_model" value="{{ auth()->user()->motorcycle_model ?? '' }}" placeholder="e.g., Click 125"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Rating *</label>
                                <select name="rating" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm font-bold text-amber-600">
                                    <option value="5">★★★★★ (5/5 - Solid / Excellent)</option>
                                    <option value="4">★★★★☆ (4/5 - Good)</option>
                                    <option value="3">★★★☆☆ (3/5 - Okay)</option>
                                    <option value="2">★★☆☆☆ (2/5 - Needs Improvement)</option>
                                    <option value="1">★☆☆☆☆ (1/5 - Poor)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Your Review *</label>
                                <textarea name="comment" rows="3" required placeholder="Kumusta ang gawa ng mekaniko o performance ng piyesa?"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#009A44] hover:bg-[#007A36] text-white font-bold py-3 rounded-xl shadow transition text-sm">
                                Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews Section (Mechanics & Products) -->
    <section id="reviews" class="bg-slate-50 border-t border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-[#009A44] mb-1">
                        <span class="h-1.5 w-4 bg-[#009A44] rounded-full"></span>
                        Rider Feedback &amp; Ratings
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mechanic &amp; Product Reviews</h2>
                    <p class="text-slate-500 text-sm mt-1">Mga totoong karanasan ng mga rider sa Balaoan Cycle Parts service bay at piyesa.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="filterReviews('all')" id="revTabAll"
                        class="rev-tab bg-slate-900 text-white px-4 py-2 rounded-full text-xs font-bold transition">
                        All Reviews ({{ $reviews->count() }})
                    </button>
                    <button type="button" onclick="filterReviews('mechanic')" id="revTabMechanic"
                        class="rev-tab bg-white border border-slate-200 text-slate-600 hover:border-[#009A44] px-4 py-2 rounded-full text-xs font-bold transition">
                        Mechanics &amp; Bay ({{ $reviews->where('type', 'mechanic')->count() }})
                    </button>
                    <button type="button" onclick="filterReviews('product')" id="revTabProduct"
                        class="rev-tab bg-white border border-slate-200 text-slate-600 hover:border-[#E30613] px-4 py-2 rounded-full text-xs font-bold transition">
                        Parts &amp; Products ({{ $reviews->where('type', 'product')->count() }})
                    </button>
                </div>
            </div>

            @if(session('review_success'))
                <div class="mb-8 bg-emerald-50 border border-[#009A44] text-[#007A36] font-semibold px-4 py-3 rounded-xl text-sm">
                    {{ session('review_success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Reviews Feed (8 cols) -->
                <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-4 content-start">
                    @foreach($reviews as $rev)
                        <div data-rev-type="{{ $rev->type }}" class="review-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    @if($rev->type === 'mechanic')
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-[#009A44] border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                            Mechanic &amp; Service Bay
                                        </span>
                                    @else
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-red-50 text-[#E30613] border border-red-200 px-2.5 py-0.5 rounded-full">
                                            Product Review
                                        </span>
                                    @endif

                                    <div class="flex items-center text-amber-400 text-sm tracking-tight" aria-label="{{ $rev->rating }} out of 5 stars">
                                        @for($s = 1; $s <= 5; $s++)
                                            <span>{{ $s <= $rev->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>

                                @if($rev->type === 'product' && $rev->part)
                                    <p class="text-xs font-extrabold text-slate-900 mb-1.5">
                                        Part: <span class="text-[#E30613]">{{ $rev->part->name }}</span>
                                    </p>
                                @endif

                                <p class="text-sm text-slate-600 leading-relaxed">"{{ $rev->comment }}"</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-extrabold text-slate-900">{{ $rev->customer_name }}</p>
                                    @if($rev->motorcycle_model)
                                        <p class="text-[11px] font-semibold text-slate-400">{{ $rev->motorcycle_model }}</p>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Leave a Review Form (4 cols) -->
                <div class="lg:col-span-4">
                    <div class="bg-white border border-slate-200 border-t-4 border-t-[#009A44] rounded-2xl p-6 shadow-sm sticky top-24">
                        <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#009A44]">Share Your Experience</span>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">Write a Review</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-5">I-rate ang serbisyo ng mekaniko o ang piyesang nabili mo.</p>

                        <form method="POST" action="{{ route('reviews.store') }}" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">What are you reviewing? *</label>
                                <select name="type" id="reviewTypeSelect" onchange="toggleReviewPartSelect()"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                                    <option value="mechanic">Mechanic &amp; Repair Service</option>
                                    <option value="product">Motorcycle Part / Product</option>
                                </select>
                            </div>

                            <div id="reviewPartWrapper" class="hidden">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Select Part / Product</label>
                                <select name="part_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#009A44]">
                                    <option value="">-- Choose Part --</option>
                                    @foreach($allPartsForReview as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Your Name *</label>
                                    <input type="text" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required placeholder="e.g., Juan D."
                                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Motorcycle</label>
                                    <input type="text" name="motorcycle_model" value="{{ auth()->user()->motorcycle_model ?? '' }}" placeholder="e.g., Click 125"
                                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Rating *</label>
                                <select name="rating" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 text-sm font-bold text-amber-600">
                                    <option value="5">★★★★★ (5/5 - Solid / Excellent)</option>
                                    <option value="4">★★★★☆ (4/5 - Good)</option>
                                    <option value="3">★★★☆☆ (3/5 - Okay)</option>
                                    <option value="2">★★☆☆☆ (2/5 - Needs Improvement)</option>
                                    <option value="1">★☆☆☆☆ (1/5 - Poor)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Your Review *</label>
                                <textarea name="comment" rows="3" required placeholder="Kumusta ang gawa ng mekaniko o performance ng piyesa?"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#009A44] hover:bg-[#007A36] text-white font-bold py-3 rounded-xl shadow transition text-sm">
                                Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="bg-slate-950 text-slate-400 border-t-4 border-[#009A44]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
            <div>
                <div class="flex items-center gap-3">
                    <div class="bg-white rounded-xl p-1.5 shadow-sm">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Balaoan Cycle Parts" class="h-10 w-auto object-contain">
                    </div>
                    <span class="font-extrabold text-white text-base">Balaoan Cycle Parts</span>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-slate-400">
                    Your trusted one-stop motorcycle parts store and repair service bay in Balaoan, La Union. Quality parts, honest mechanics.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-3">Quick Navigation</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#parts" class="hover:text-white transition">Parts &amp; Accessories Catalog</a></li>
                    <li><a href="#services" class="hover:text-white transition">Repair &amp; Maintenance Rates</a></li>
                    <li><a href="#tracker" class="hover:text-white transition">Live Service Bay Tracker</a></li>
                    <li><a href="#booking" class="hover:text-white transition">Book a Repair Appointment</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white text-xs uppercase tracking-wider mb-3">Shop Location &amp; Hours</h4>
                <p class="text-xs">Balaoan, La Union, Philippines</p>
                <p class="text-xs mt-1">Monday &ndash; Saturday: 8:00 AM &ndash; 5:30 PM</p>
                <p class="text-xs mt-3 text-emerald-400 font-semibold">Walk-ins &amp; Online Reservations Welcome</p>
            </div>
        </div>
        <div class="border-t border-slate-900 py-5 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} Balaoan Cycle Parts. All rights reserved.
        </div>
    </footer>

    <!-- Product Quick-View Modal -->
    <div id="partModal" onclick="if(event.target === this) closePartModal()"
        class="hidden fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl border-t-4 border-[#009A44]">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="bg-slate-100 aspect-square flex items-center justify-center overflow-hidden border-b md:border-b-0 md:border-r border-slate-200">
                    <img id="modalImage" src="" alt="" class="hidden w-full h-full object-cover">
                    <div id="modalNoImage" class="text-center p-6">
                        <span class="text-sm font-extrabold uppercase tracking-widest text-[#009A44] block">Balaoan Cycle Parts</span>
                        <span class="text-xs text-slate-400 mt-1 block">No Photo Uploaded</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <span id="modalCategory" class="bg-slate-900 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider"></span>
                            <button onclick="closePartModal()" class="text-slate-400 hover:text-[#E30613] font-black text-xl leading-none">&times;</button>
                        </div>
                        <p id="modalSku" class="text-xs font-bold text-slate-400 uppercase mt-3"></p>
                        <h3 id="modalName" class="text-xl font-extrabold text-slate-900 mt-0.5"></h3>
                        <p id="modalPrice" class="text-2xl font-extrabold text-[#E30613] mt-2"></p>
                        <div id="modalStock" class="mt-2"></div>
                        <p id="modalDescription" class="text-sm text-slate-600 mt-4 leading-relaxed"></p>
                        <div id="modalBikesWrapper" class="mt-4 hidden">
                            <span class="text-[11px] font-bold uppercase text-slate-400 block mb-1.5">Compatible Motorcycles:</span>
                            <div id="modalBikes" class="flex flex-wrap gap-1"></div>
                        </div>
                    </div>

                    <div id="modalActions" class="mt-6 pt-4 border-t border-slate-100 grid grid-cols-2 gap-2.5"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide-Over Cart & Checkout Drawer -->
    <div id="cartDrawer" onclick="if(event.target === this) closeCartDrawer()"
        class="hidden fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-sm flex justify-end">
        <div class="bg-white w-full max-w-lg h-full flex flex-col shadow-2xl border-l-4 border-[#009A44]">
            <div class="p-5 bg-slate-900 text-white flex items-center justify-between border-b-2 border-[#E30613]">
                <div>
                    <h2 class="text-lg font-extrabold tracking-tight">Shopping Cart &amp; Checkout</h2>
                    <p class="text-xs text-slate-400">Piliin kung Parts Pickup o With Installation</p>
                </div>
                <button onclick="closeCartDrawer()" class="text-slate-400 hover:text-white text-2xl font-black leading-none">&times;</button>
            </div>

            <div class="flex-1 overflow-y-auto p-5 space-y-6">
                <div id="cartItemsContainer" class="space-y-3"></div>

                <form id="cartCheckoutForm" method="POST" action="{{ route('cart.checkout') }}" class="space-y-4 border-t border-slate-200 pt-5">
                    @csrf
                    <input type="hidden" name="cart_json" id="cartJsonInput">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Order Option *</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="cursor-pointer">
                                <input type="radio" name="order_type" value="pickup_only" checked onchange="toggleInstallFields()" class="peer sr-only">
                                <div class="border-2 border-slate-200 peer-checked:border-[#009A44] peer-checked:bg-emerald-50/70 rounded-xl p-3 text-center transition">
                                    <span class="block font-extrabold text-sm text-slate-900">Parts Only</span>
                                    <span class="block text-[11px] text-slate-500">Pickup sa Shop</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="order_type" value="with_installation" onchange="toggleInstallFields()" class="peer sr-only">
                                <div class="border-2 border-slate-200 peer-checked:border-[#E30613] peer-checked:bg-red-50/70 rounded-xl p-3 text-center transition">
                                    <span class="block font-extrabold text-sm text-slate-900">Buy + Install</span>
                                    <span class="block text-[11px] text-slate-500">Ipapakabit sa Mekaniko</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number *</label>
                            <input type="text" name="customer_phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="09XX-XXX-XXXX" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method *</label>
                        <select name="payment_method" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm">
                            <option value="cash">Cash upon Pickup / Service</option>
                            <option value="gcash">GCash</option>
                        </select>
                    </div>

                    <div id="installFields" class="hidden space-y-3 bg-red-50/60 border border-red-200 rounded-xl p-4">
                        <p class="text-xs font-extrabold text-[#E30613] uppercase tracking-wider">Installation Details</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Motorcycle Model *</label>
                                <input type="text" name="custom_motorcycle" id="cartMotoInput" value="{{ auth()->user()->motorcycle_model ?? '' }}" placeholder="e.g., Yamaha NMAX 155"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Plate Number</label>
                                <input type="text" name="plate_number" value="{{ auth()->user()->plate_number ?? '' }}" placeholder="Optional"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Installation Service *</label>
                                <select name="service_id" id="cartServiceSelect" onchange="renderCart()"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm">
                                    <option value="" data-price="0">-- Choose Service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->labor_price }}">
                                            {{ $service->name }} (+&#8369;{{ number_format($service->labor_price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Preferred Schedule *</label>
                                <input type="datetime-local" name="scheduled_at" id="cartScheduleInput"
                                    class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Notes (Optional)</label>
                        <textarea name="notes" rows="2" placeholder="Dagdag na bilin sa shop..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2 text-sm"></textarea>
                    </div>
                </form>
            </div>

            <div class="p-5 bg-slate-50 border-t border-slate-200 space-y-2.5">
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Parts Subtotal:</span>
                    <span id="cartPartsSubtotal" class="font-bold text-slate-800">&#8369;0.00</span>
                </div>
                <div id="cartLaborRow" class="hidden flex justify-between text-xs text-slate-500">
                    <span>Estimated Installation Labor:</span>
                    <span id="cartLaborSubtotal" class="font-bold text-[#009A44]">&#8369;0.00</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                    <span class="font-extrabold text-sm uppercase text-slate-700">Total Amount:</span>
                    <span id="cartGrandTotal" class="text-2xl font-extrabold text-[#E30613]">&#8369;0.00</span>
                </div>
                <button type="button" onclick="submitCartOrder()" class="w-full bg-[#E30613] hover:bg-red-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">
                    Place Order Now
                </button>
            </div>
        </div>
    </div>

    <script>
        const PESO = '\u20B1';
        let cart = JSON.parse(localStorage.getItem('bcp_cart') || '[]');
        let currentModalPart = null;

        function saveCart() {
            localStorage.setItem('bcp_cart', JSON.stringify(cart));
            function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        renderCart();
        }

        function addToCart(part, mode = 'pickup_only', openDrawerAfter = false) {
            const existing = cart.find(i => i.id === part.id);
            if (existing) {
                if (existing.qty < part.stock) {
                    existing.qty += 1;
                } else {
                    alert('Naabot mo na ang maximum available stock para sa piyesang ito.');
                }
            } else {
                cart.push({
                    id: part.id,
                    name: part.name,
                    price: part.price,
                    stock: part.stock,
                    qty: 1
                });
            }

            const radio = document.querySelector(`input[name="order_type"][value="${mode}"]`);
            if (radio) {
                radio.checked = true;
                toggleInstallFields();
            }

            saveCart();
            if (openDrawerAfter) {
                openCartDrawer();
            }
        }

        function changeQty(id, delta) {
            const item = cart.find(i => i.id === id);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => i.id !== id);
            } else if (item.qty > item.stock) {
                item.qty = item.stock;
            }
            saveCart();
        }

        function toggleInstallFields() {
            const mode = document.querySelector('input[name="order_type"]:checked')?.value;
            const box = document.getElementById('installFields');
            const laborRow = document.getElementById('cartLaborRow');
            const isInstall = mode === 'with_installation';

            box.classList.toggle('hidden', !isInstall);
            laborRow.classList.toggle('hidden', !isInstall);
            document.getElementById('cartMotoInput').required = isInstall;
            document.getElementById('cartServiceSelect').required = isInstall;
            document.getElementById('cartScheduleInput').required = isInstall;
            function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        renderCart();
        }

        function renderCart() {
            const totalCount = cart.reduce((sum, i) => sum + i.qty, 0);
            document.getElementById('cartBadge').textContent = totalCount;

            const container = document.getElementById('cartItemsContainer');
            if (cart.length === 0) {
                container.innerHTML = `<div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-8 text-center text-sm text-slate-500">Walang laman ang cart mo. Pumili muna ng piyesa sa catalog!</div>`;
            } else {
                container.innerHTML = cart.map(item => `
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex items-center justify-between gap-3">
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">${item.name}</h4>
                            <p class="text-xs font-extrabold text-[#E30613] mt-0.5">${PESO}${(item.price * item.qty).toLocaleString('en-PH', {minimumFractionDigits: 2})}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="changeQty(${item.id}, -1)" class="w-7 h-7 rounded-lg bg-slate-200 hover:bg-slate-300 font-extrabold text-sm">-</button>
                            <span class="w-6 text-center text-sm font-bold">${item.qty}</span>
                            <button type="button" onclick="changeQty(${item.id}, 1)" class="w-7 h-7 rounded-lg bg-[#009A44] text-white font-extrabold text-sm">+</button>
                        </div>
                    </div>
                `).join('');
            }

            const partsTotal = cart.reduce((sum, i) => sum + (i.price * i.qty), 0);
            const mode = document.querySelector('input[name="order_type"]:checked')?.value;
            let labor = 0;
            if (mode === 'with_installation') {
                const sel = document.getElementById('cartServiceSelect');
                labor = parseFloat(sel.options[sel.selectedIndex]?.dataset?.price || 0);
            }

            document.getElementById('cartPartsSubtotal').textContent = PESO + partsTotal.toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('cartLaborSubtotal').textContent = PESO + labor.toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('cartGrandTotal').textContent = PESO + (partsTotal + labor).toLocaleString('en-PH', {minimumFractionDigits: 2});
        }

        function submitCartOrder() {
            if (cart.length === 0) {
                alert('Maglagay muna ng kahit isang piyesa sa cart!');
                return;
            }
            document.getElementById('cartJsonInput').value = JSON.stringify(cart);
            const form = document.getElementById('cartCheckoutForm');
            if (form.reportValidity()) {
                form.submit();
            }
        }

        function openCartDrawer() {
            function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        renderCart();
            document.getElementById('cartDrawer').classList.remove('hidden');
        }

        function closeCartDrawer() {
            document.getElementById('cartDrawer').classList.add('hidden');
        }

        function handleModalAction(mode) {
            if (!currentModalPart) return;
            addToCart(currentModalPart, mode, true);
            closePartModal();
        }

        function openPartModal(part) {
            currentModalPart = part;
            document.getElementById('modalCategory').textContent = part.category;
            document.getElementById('modalSku').textContent = `${part.brand} \u2022 ${part.sku}`;
            document.getElementById('modalName').textContent = part.name;
            document.getElementById('modalPrice').textContent = PESO + Number(part.price).toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('modalDescription').textContent = part.description;

            const img = document.getElementById('modalImage');
            const noImg = document.getElementById('modalNoImage');
            if (part.image) {
                img.src = part.image;
                img.classList.remove('hidden');
                noImg.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                noImg.classList.remove('hidden');
            }

            const stockEl = document.getElementById('modalStock');
            const actionsEl = document.getElementById('modalActions');
            const isLoggedIn = document.body.dataset.loggedIn === '1';
            if (part.stock > 0) {
                stockEl.innerHTML = `<span class="inline-block text-xs font-bold text-[#009A44] bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">${part.stock} pcs available</span>`;
                if (isLoggedIn) {
                    actionsEl.innerHTML = `
                        <button type="button" onclick="handleModalAction('pickup_only')" class="bg-white hover:bg-[#009A44] text-[#009A44] hover:text-white border border-[#009A44] font-bold py-2.5 px-3 rounded-xl text-xs transition">Add to Cart</button>
                        <button type="button" onclick="handleModalAction('with_installation')" class="bg-[#E30613] hover:bg-red-700 text-white font-bold py-2.5 px-3 rounded-xl text-xs shadow-sm transition">Buy + Install</button>
                    `;
                } else {
                    actionsEl.innerHTML = `
                        <a href="{{ route('customer.login') }}" class="col-span-2 text-center bg-slate-900 hover:bg-[#009A44] text-white font-bold py-2.5 px-3 rounded-xl text-xs transition">Login or Create Account to Order &rarr;</a>
                    `;
                }
            } else {
                stockEl.innerHTML = `<span class="inline-block text-xs font-bold text-[#E30613] bg-red-50 border border-red-200 px-2.5 py-1 rounded-full">Out of Stock</span>`;
                actionsEl.innerHTML = `<button type="button" onclick="closePartModal()" class="col-span-2 bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs">Close</button>`;
            }

            const bikesWrap = document.getElementById('modalBikesWrapper');
            const bikesEl = document.getElementById('modalBikes');
            if (part.bikes && part.bikes.length > 0) {
                bikesEl.innerHTML = part.bikes.map(b => `<span class="text-xs font-bold bg-emerald-50 text-[#009A44] px-2.5 py-0.5 rounded-md">${b}</span>`).join('');
                bikesWrap.classList.remove('hidden');
            } else {
                bikesWrap.classList.add('hidden');
            }

            document.getElementById('partModal').classList.remove('hidden');
        }

        function closePartModal() {
            document.getElementById('partModal').classList.add('hidden');
        }

        function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        function toggleReviewPartSelect() {
            const type = document.getElementById('reviewTypeSelect').value;
            document.getElementById('reviewPartWrapper').classList.toggle('hidden', type !== 'product');
        }

        function filterReviews(filter) {
            document.querySelectorAll('.review-card').forEach(card => {
                const match = filter === 'all' || card.dataset.revType === filter;
                card.classList.toggle('hidden', !match);
            });

            document.querySelectorAll('.rev-tab').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'bg-[#009A44]', 'bg-[#E30613]', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            });

            const activeBtn = filter === 'mechanic'
                ? document.getElementById('revTabMechanic')
                : (filter === 'product' ? document.getElementById('revTabProduct') : document.getElementById('revTabAll'));

            const activeColor = filter === 'mechanic' ? 'bg-[#009A44]' : (filter === 'product' ? 'bg-[#E30613]' : 'bg-slate-900');
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
            activeBtn.classList.add(activeColor, 'text-white');
        }

        renderCart();
    </script>

</body>
</html>

