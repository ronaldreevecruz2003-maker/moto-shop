<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $sale->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-100 py-8 font-mono text-slate-900">

    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden border border-slate-200">
        <div class="h-2 w-full flex">
            <div class="w-1/2 bg-[#009A44]"></div>
            <div class="w-1/4 bg-white"></div>
            <div class="w-1/4 bg-[#E30613]"></div>
        </div>

        <div class="p-6">
            <div class="text-center border-b-2 border-dashed border-slate-300 pb-4">
                <h1 class="text-xl font-black text-[#009A44] uppercase tracking-wide">Balaoan Cycle Parts</h1>
                <p class="text-xs text-slate-500 mt-0.5">Balaoan, La Union</p>
                <p class="text-[11px] font-bold text-[#E30613] uppercase mt-1">Official Sales Slip</p>
            </div>

            <div class="py-3 text-xs space-y-1 border-b-2 border-dashed border-slate-300">
                <div class="flex justify-between">
                    <span class="text-slate-500">Invoice #:</span>
                    <span class="font-bold">{{ $sale->invoice_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Date:</span>
                    <span>{{ $sale->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Customer:</span>
                    <span class="font-semibold">{{ $sale->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Payment:</span>
                    <span class="uppercase font-bold text-[#009A44]">{{ $sale->payment_method }}</span>
                </div>
            </div>

            <table class="w-full text-xs my-3">
                <thead>
                    <tr class="border-b border-slate-300 text-slate-500 text-left">
                        <th class="py-1.5">Item</th>
                        <th class="py-1.5 text-center">Qty</th>
                        <th class="py-1.5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="py-2 pr-2">
                                <div class="font-bold text-slate-800">{{ $item->part->name ?? 'Deleted Part' }}</div>
                                <div class="text-[10px] text-slate-400">?{{ number_format($item->unit_price, 2) }} each</div>
                            </td>
                            <td class="py-2 text-center font-semibold">{{ $item->quantity }}</td>
                            <td class="py-2 text-right font-bold">?{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-t-2 border-dashed border-slate-300 pt-3 mt-2 flex justify-between items-center">
                <span class="text-sm font-black uppercase">Grand Total</span>
                <span class="text-xl font-black text-[#E30613]">?{{ number_format($sale->total_amount, 2) }}</span>
            </div>

            @if($sale->notes)
                <div class="mt-3 pt-2 border-t border-slate-100 text-[11px] text-slate-500">
                    <span class="font-bold">Notes:</span> {{ $sale->notes }}
                </div>
            @endif

            <div class="mt-6 text-center text-[11px] text-slate-500 border-t border-slate-200 pt-4">
                <p class="font-bold text-[#009A44]">Salamat sa pagtangkilik!</p>
                <p>Ride safe, ka-rider!</p>
            </div>

            <div class="no-print mt-6 flex gap-3">
                <button onclick="window.print()" class="flex-1 bg-[#E30613] hover:bg-red-700 text-white font-bold py-2.5 rounded-lg text-xs uppercase tracking-wider transition">
                    Print Receipt
                </button>
                <a href="/admin/sales" class="flex-1 text-center bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold py-2.5 rounded-lg text-xs uppercase tracking-wider transition">
                    Back to Admin
                </a>
            </div>
        </div>
    </div>

</body>
</html>
