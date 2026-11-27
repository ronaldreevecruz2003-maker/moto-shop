<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice {{ $sale->invoice_number }} — Balaoan Cycle Parts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; padding: 0 !important; }
            .receipt-box {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                max-width: 80mm !important;
                margin: 0 auto !important;
                padding: 4mm !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 py-8 px-4 text-slate-900 antialiased">
    <div class="no-print max-w-md mx-auto mb-5 flex items-center justify-between gap-2">
        <a href="{{ route('pos.index') }}" class="px-4 py-2.5 rounded-lg bg-[#009A44] hover:bg-[#008239] text-white text-xs font-bold uppercase tracking-wider shadow-xs transition">
            + New Transaction
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider shadow-xs transition">
                Print Receipt
            </button>
            <a href="/admin" class="px-4 py-2.5 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold uppercase tracking-wider transition">
                Admin
            </a>
        </div>
    </div>

    <div class="receipt-box max-w-md mx-auto bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden font-mono text-xs">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#009A44] to-[#E30613]"></div>

        <div class="p-6">
            <div class="text-center border-b border-dashed border-slate-300 pb-4 mb-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-14 w-14 mx-auto mb-2.5 rounded-lg object-cover border border-slate-200">
                <h1 class="text-base font-extrabold tracking-wide text-slate-900">BALAOAN CYCLE PARTS</h1>
                <p class="text-slate-600">Balaoan, La Union</p>
                <p class="text-[11px] font-bold uppercase tracking-widest text-[#009A44] mt-1.5">Sales Invoice / Receipt</p>
            </div>

            <div class="space-y-1.5 mb-4 text-slate-700">
                <div class="flex justify-between"><span class="text-slate-500">Invoice No:</span><span class="font-bold text-slate-900">{{ $sale->invoice_number }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Date &amp; Time:</span><span>{{ $sale->created_at->format('M d, Y h:i A') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Customer:</span><span class="font-semibold">{{ $sale->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Cashier:</span><span>{{ $sale->user->name ?? 'Staff' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Payment:</span><span class="font-bold">{{ $sale->payment_method }}</span></div>
                @if($sale->gcash_reference)
                    <div class="flex justify-between"><span class="text-slate-500">GCash Ref:</span><span class="font-bold">{{ $sale->gcash_reference }}</span></div>
                @endif
            </div>

            <table class="w-full border-t border-b border-dashed border-slate-300 py-2 mb-4">
                <thead>
                    <tr class="text-left text-slate-500 border-b border-slate-200">
                        <th class="py-1.5">Description</th>
                        <th class="py-1.5 text-center">Qty</th>
                        <th class="py-1.5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="py-2 pr-2">
                                <div class="font-bold text-slate-900">{{ $item->part->name ?? 'Part' }}</div>
                                <div class="text-[11px] text-slate-500">{{ $item->part->sku ?? '' }} @ ₱{{ number_format($item->unit_price, 2) }}</div>
                            </td>
                            <td class="py-2 text-center font-semibold">{{ $item->quantity }}</td>
                            <td class="py-2 text-right font-bold text-slate-900">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="space-y-1.5">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span>₱{{ number_format($sale->subtotal, 2) }}</span>
                </div>
                @if($sale->discount > 0)
                    <div class="flex justify-between text-[#E30613]">
                        <span>Discount:</span>
                        <span>-₱{{ number_format($sale->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm font-extrabold text-slate-900 pt-2 border-t border-slate-200">
                    <span>TOTAL PAID:</span>
                    <span class="text-[#009A44]">₱{{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-600 pt-1">
                    <span>Amount Tendered:</span>
                    <span>₱{{ number_format($sale->amount_tendered, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-slate-900">
                    <span>Change:</span>
                    <span>₱{{ number_format($sale->change_amount, 2) }}</span>
                </div>
            </div>

            <div class="text-center border-t border-dashed border-slate-300 pt-4 mt-5 text-slate-500 space-y-0.5">
                <p class="font-bold text-slate-800">Thank you for your business!</p>
                <p class="text-[11px]">Keep this receipt for warranty &amp; reference.</p>
            </div>
        </div>
    </div>
</body>
</html>