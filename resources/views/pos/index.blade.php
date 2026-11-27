<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Point of Sale — Balaoan Cycle Parts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .cart-row-enter { animation: slideIn 180ms cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col antialiased">
    <div class="h-1.5 w-full bg-gradient-to-r from-[#009A44] via-[#009A44] to-[#E30613]"></div>

    <header class="bg-white border-b border-slate-200 shadow-xs px-6 py-3 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <img src="{{ asset('images/logo.jpg') }}" alt="Balaoan Cycle Parts" class="h-12 w-12 rounded-lg object-cover border border-slate-200 shadow-xs">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-lg font-extrabold tracking-tight text-slate-900">
                        BALAOAN <span class="text-[#009A44]">CYCLE</span> <span class="text-[#E30613]">PARTS</span>
                    </h1>
                    <span class="hidden sm:inline-block text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-[#009A44] border border-emerald-200">
                        Walk-In POS
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Balaoan, La Union &bull; Cashier: <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span id="liveClock" class="hidden md:inline-block text-xs font-medium text-slate-500 bg-slate-50 border border-slate-200 px-3 py-2 rounded-lg"></span>
            <a href="/admin" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider bg-slate-900 hover:bg-slate-800 text-white shadow-xs transition duration-150">
                &larr; Admin Dashboard
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-[1440px] w-full mx-auto p-4 lg:p-5 grid grid-cols-1 lg:grid-cols-12 gap-5">
        <section class="lg:col-span-7 bg-white rounded-xl shadow-xs border border-slate-200 flex flex-col overflow-hidden">
            <div class="p-4 border-b border-slate-200 bg-slate-50/70 space-y-3">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/>
                        </svg>
                    </div>
                    <input id="searchInput" type="text" placeholder="Search by SKU, part name, brand, or motorcycle model... (Press / to focus)"
                        class="w-full pl-10 pr-20 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#009A44]/30 focus:border-[#009A44] bg-white text-sm transition duration-150">
                    <button type="button" id="clearSearchBtn" onclick="resetFilters()" class="hidden absolute inset-y-1.5 right-2 px-2.5 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 rounded-md transition">
                        Clear
                    </button>
                </div>

                @php
                    $categories = $parts->map(fn ($p) => $p->category?->name)->filter()->unique()->values();
                @endphp
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-0.5">
                    <button type="button" onclick="selectCategory('all', this)"
                        class="cat-pill active-pill shrink-0 px-3 py-1.5 rounded-md text-xs font-bold bg-[#009A44] text-white shadow-xs transition duration-150">
                        All Parts ({{ $parts->count() }})
                    </button>
                    @foreach($categories as $category)
                        <button type="button" onclick="selectCategory('{{ strtolower($category) }}', this)"
                            class="cat-pill shrink-0 px-3 py-1.5 rounded-md text-xs font-semibold bg-white text-slate-600 border border-slate-200 hover:border-[#009A44] hover:text-[#009A44] transition duration-150">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div id="partsGrid" class="p-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 overflow-y-auto max-h-[70vh]">
                @foreach($parts as $part)
                    @php
                        $inStock = $part->stock_quantity > 0;
                        $isLow = $inStock && $part->stock_quantity <= ($part->reorder_level ?? 5);
                        $catName = $part->category?->name ?? '';
                        $compatText = $part->compatibleModels->pluck('name')->join(', ');
                    @endphp
                    <div class="part-card group border rounded-xl p-3.5 flex flex-col justify-between transition-all duration-150 {{ $inStock ? 'bg-white border-slate-200 hover:border-[#009A44] hover:shadow-md hover:-translate-y-0.5 cursor-pointer active:scale-[0.99]' : 'bg-slate-50 border-slate-200 opacity-55 cursor-not-allowed' }}"
                         data-category="{{ strtolower($catName) }}"
                         data-search="{{ strtolower($part->sku . ' ' . $part->name . ' ' . $part->brand . ' ' . $catName . ' ' . $compatText) }}"
                         onclick='addToCart(@json($part))'>
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $part->sku }}
                                </span>
                                @if(!$inStock)
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-red-50 text-[#E30613] border border-red-200">
                                        Out of Stock
                                    </span>
                                @elseif($isLow)
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                        Low: {{ $part->stock_quantity }}
                                    </span>
                                @else
                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-[#009A44] border border-emerald-200">
                                        {{ $part->stock_quantity }} in stock
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-bold text-sm text-slate-900 group-hover:text-[#009A44] transition-colors leading-snug">
                                {{ $part->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">
                                {{ $part->brand ?: 'Generic' }} &bull; {{ $compatText ?: 'Universal Fit' }}
                            </p>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-base font-extrabold text-slate-900">
                                ₱{{ number_format($part->price, 2) }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">
                                Rack {{ $part->rack_location ?: '—' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="lg:col-span-5 bg-white rounded-xl shadow-xs border border-slate-200 flex flex-col justify-between overflow-hidden">
            <div class="px-4 py-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <h2 class="font-extrabold text-sm uppercase tracking-wider text-slate-800">Order Summary</h2>
                    <span id="cartCountBadge" class="text-xs font-bold px-2 py-0.5 rounded-full bg-[#009A44] text-white">0</span>
                </div>
                <button type="button" onclick="clearCart()" class="text-xs font-bold text-[#E30613] hover:bg-red-50 px-2.5 py-1 rounded-md transition duration-150">
                    Clear Order
                </button>
            </div>

            <div id="cartItems" class="p-4 flex-1 overflow-y-auto max-h-[34vh] space-y-2.5 bg-slate-50/30">
                <div class="text-center py-12 text-slate-400">
                    <p class="text-sm font-medium text-slate-500">No items added yet</p>
                    <p class="text-xs mt-1">Select any available part from the catalog to begin.</p>
                </div>
            </div>

            <div class="p-4 border-t border-slate-200 bg-white space-y-3.5">
                <div class="grid grid-cols-12 gap-2.5">
                    <div class="col-span-7">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Customer Name</label>
                        <input id="customerName" type="text" placeholder="Walk-In Customer"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:border-[#009A44] text-sm bg-white transition">
                    </div>
                    <div class="col-span-5">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Discount (₱)</label>
                        <input id="discountInput" type="number" min="0" step="1" value="0" oninput="renderCart()"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:border-[#009A44] text-sm font-semibold bg-white transition">
                    </div>
                </div>

                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-1.5 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span id="subtotalText" class="font-semibold text-slate-800">₱0.00</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Discount</span>
                        <span id="discountText" class="font-semibold text-[#E30613]">-₱0.00</span>
                    </div>
                    <div class="flex justify-between items-baseline text-lg font-extrabold text-slate-900 pt-2 border-t border-slate-200">
                        <span>Total Payable</span>
                        <span id="totalText" class="text-xl text-[#009A44]">₱0.00</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Payment Method</label>
                        <select id="paymentMethod" onchange="togglePaymentFields()"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:border-[#009A44] text-sm bg-white font-bold text-slate-800 transition">
                            <option value="Cash">Cash</option>
                            <option value="GCash">GCash</option>
                        </select>
                    </div>
                    <div id="tenderedBox">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Cash Tendered (₱)</label>
                        <input id="amountTendered" type="number" min="0" step="1" placeholder="0.00" oninput="updateChange()"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:border-[#009A44] text-sm bg-white font-extrabold text-slate-900 transition">
                    </div>
                    <div id="gcashBox" class="hidden">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">GCash Ref. No.</label>
                        <input id="gcashRef" type="text" placeholder="13-digit ref no."
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:border-[#009A44] text-sm bg-white font-mono transition">
                    </div>
                </div>

                <div id="quickCashRow" class="flex flex-wrap items-center gap-1.5">
                    <button type="button" onclick="setExactTender()" class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 text-[#009A44] border border-emerald-200 hover:bg-emerald-100 transition">
                        Exact
                    </button>
                    @foreach([100, 200, 500, 1000] as $bill)
                        <button type="button" onclick="setTender({{ $bill }})" class="px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 hover:bg-slate-200 transition">
                            ₱{{ number_format($bill) }}
                        </button>
                    @endforeach
                </div>

                <div id="changeRow" class="flex justify-between items-center px-3.5 py-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200 text-sm">
                    <span class="font-bold text-slate-700">Change Due</span>
                    <span id="changeText" class="font-extrabold text-lg text-[#009A44]">₱0.00</span>
                </div>

                <p id="errorBox" class="hidden text-xs font-bold text-[#E30613] bg-red-50 border border-red-200 px-3.5 py-2.5 rounded-lg"></p>

                <button id="checkoutBtn" type="button" onclick="submitCheckout()"
                    class="w-full py-3.5 rounded-xl bg-[#009A44] hover:bg-[#008239] active:scale-[0.99] text-white font-extrabold text-sm uppercase tracking-wider shadow-sm transition-all duration-150">
                    Complete Sale &amp; Issue Receipt
                </button>
            </div>
        </section>
    </main>

    <div id="toast" class="fixed bottom-5 right-5 z-50 pointer-events-none opacity-0 translate-y-2 transition-all duration-200 bg-slate-900 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-lg border-l-4 border-[#009A44]"></div>

    <script>
        let cart = [];
        let activeCategory = 'all';
        let toastTimer = null;

        function updateClock() {
            const el = document.getElementById('liveClock');
            if (!el) return;
            el.textContent = new Date().toLocaleString('en-PH', {
                weekday: 'short', month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }
        updateClock();
        setInterval(updateClock, 30000);

        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }
        });

        document.getElementById('searchInput').addEventListener('input', filterCatalog);

        function selectCategory(cat, btn) {
            activeCategory = cat;
            document.querySelectorAll('.cat-pill').forEach(p => {
                p.className = 'cat-pill shrink-0 px-3 py-1.5 rounded-md text-xs font-semibold bg-white text-slate-600 border border-slate-200 hover:border-[#009A44] hover:text-[#009A44] transition duration-150';
            });
            btn.className = 'cat-pill shrink-0 px-3 py-1.5 rounded-md text-xs font-bold bg-[#009A44] text-white shadow-xs transition duration-150';
            filterCatalog();
        }

        function filterCatalog() {
            const q = document.getElementById('searchInput').value.toLowerCase().trim();
            document.getElementById('clearSearchBtn').classList.toggle('hidden', q === '' && activeCategory === 'all');

            document.querySelectorAll('.part-card').forEach(card => {
                const matchesSearch = card.dataset.search.includes(q);
                const matchesCat = activeCategory === 'all' || card.dataset.category === activeCategory;
                card.style.display = (matchesSearch && matchesCat) ? 'flex' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            const firstPill = document.querySelector('.cat-pill');
            if (firstPill) selectCategory('all', firstPill);
        }

        function showToast(text) {
            const toast = document.getElementById('toast');
            toast.textContent = text;
            toast.classList.remove('opacity-0', 'translate-y-2');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
            }, 1600);
        }

        function addToCart(part) {
            if (part.stock_quantity <= 0) return;
            const existing = cart.find(item => item.id === part.id);
            if (existing) {
                if (existing.quantity >= part.stock_quantity) {
                    showError(`Maximum available stock reached for ${part.name} (${part.stock_quantity}).`);
                    return;
                }
                existing.quantity++;
            } else {
                cart.push({
                    id: part.id,
                    sku: part.sku,
                    name: part.name,
                    price: parseFloat(part.price),
                    maxStock: parseInt(part.stock_quantity),
                    quantity: 1
                });
            }
            hideError();
            renderCart();
            showToast(`Added ${part.name}`);
        }

        function updateQty(id, delta) {
            const item = cart.find(i => i.id === id);
            if (!item) return;
            const nextQty = item.quantity + delta;
            if (nextQty <= 0) {
                cart = cart.filter(i => i.id !== id);
            } else if (nextQty > item.maxStock) {
                showError(`Only ${item.maxStock} units available for ${item.name}.`);
                return;
            } else {
                item.quantity = nextQty;
                hideError();
            }
            renderCart();
        }

        function clearCart() {
            cart = [];
            document.getElementById('discountInput').value = 0;
            document.getElementById('amountTendered').value = '';
            hideError();
            renderCart();
        }

        function getTotals() {
            const subtotal = cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
            const rawDiscount = parseFloat(document.getElementById('discountInput').value) || 0;
            const discount = Math.min(Math.max(0, rawDiscount), subtotal);
            const total = Math.max(0, subtotal - discount);
            return { subtotal, discount, total };
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            const totalUnits = cart.reduce((sum, i) => sum + i.quantity, 0);
            document.getElementById('cartCountBadge').textContent = totalUnits;

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 text-slate-400">
                        <p class="text-sm font-medium text-slate-500">No items added yet</p>
                        <p class="text-xs mt-1">Select any available part from the catalog to begin.</p>
                    </div>`;
            } else {
                container.innerHTML = cart.map(item => `
                    <div class="cart-row-enter flex items-center justify-between gap-2.5 p-3 rounded-xl border border-slate-200 bg-white shadow-2xs">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-mono font-bold text-slate-400">${item.sku}</span>
                            <p class="text-sm font-bold text-slate-900 truncate">${item.name}</p>
                            <p class="text-xs text-[#009A44] font-semibold">₱${item.price.toFixed(2)} / unit</p>
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-lg border border-slate-200">
                            <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded bg-white hover:bg-slate-200 font-bold text-slate-700 text-xs shadow-2xs transition">-</button>
                            <span class="w-6 text-center text-xs font-extrabold text-slate-900">${item.quantity}</span>
                            <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded bg-white hover:bg-slate-200 font-bold text-slate-700 text-xs shadow-2xs transition">+</button>
                        </div>
                        <div class="w-20 text-right font-extrabold text-sm text-slate-900">
                            ₱${(item.price * item.quantity).toFixed(2)}
                        </div>
                    </div>
                `).join('');
            }

            const { subtotal, discount, total } = getTotals();
            document.getElementById('subtotalText').textContent = `₱${subtotal.toFixed(2)}`;
            document.getElementById('discountText').textContent = `-₱${discount.toFixed(2)}`;
            document.getElementById('totalText').textContent = `₱${total.toFixed(2)}`;
            updateChange();
        }

        function setExactTender() {
            const { total } = getTotals();
            document.getElementById('amountTendered').value = total.toFixed(2);
            updateChange();
        }

        function setTender(amount) {
            document.getElementById('amountTendered').value = amount;
            updateChange();
        }

        function togglePaymentFields() {
            const method = document.getElementById('paymentMethod').value;
            const isGCash = method === 'GCash';
            document.getElementById('tenderedBox').classList.toggle('hidden', isGCash);
            document.getElementById('quickCashRow').classList.toggle('hidden', isGCash);
            document.getElementById('gcashBox').classList.toggle('hidden', !isGCash);
            document.getElementById('changeRow').classList.toggle('hidden', isGCash);
            updateChange();
        }

        function updateChange() {
            const { total } = getTotals();
            const tendered = parseFloat(document.getElementById('amountTendered').value) || 0;
            const change = Math.max(0, tendered - total);
            document.getElementById('changeText').textContent = `₱${change.toFixed(2)}`;
        }

        function showError(msg) {
            const box = document.getElementById('errorBox');
            box.textContent = msg;
            box.classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('errorBox').classList.add('hidden');
        }

        async function submitCheckout() {
            if (cart.length === 0) {
                showError('Please add at least one part to the order.');
                return;
            }

            const { discount, total } = getTotals();
            const method = document.getElementById('paymentMethod').value;
            const tendered = method === 'GCash' ? total : (parseFloat(document.getElementById('amountTendered').value) || 0);

            if (method === 'Cash' && tendered < total) {
                showError('Cash tendered must be equal to or greater than the Total Payable.');
                return;
            }

            const btn = document.getElementById('checkoutBtn');
            btn.disabled = true;
            btn.textContent = 'Processing Transaction...';

            try {
                const res = await fetch('{{ route("pos.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        customer_name: document.getElementById('customerName').value,
                        discount: discount,
                        payment_method: method,
                        gcash_reference: document.getElementById('gcashRef').value,
                        amount_tendered: tendered,
                        items: cart.map(i => ({ part_id: i.id, quantity: i.quantity }))
                    })
                });

                const data = await res.json();
                if (!res.ok) {
                    showError(data.message || 'Unable to complete transaction.');
                    btn.disabled = false;
                    btn.textContent = 'Complete Sale & Issue Receipt';
                    return;
                }

                window.location.href = data.receipt_url;
            } catch (err) {
                showError('Network error while recording sale.');
                btn.disabled = false;
                btn.textContent = 'Complete Sale & Issue Receipt';
            }
        }
    </script>
</body>
</html>