<!DOCTYPE html>
<html lang="en" class="h-full bg-zinc-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Official Invoice #{{ $order->order_number }} — ATELIER ÉLITE</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])

    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 15mm 15mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: #1a1a1a;
            background-color: #f4f4f5;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .font-luxury-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-luxury-brand {
            font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .invoice-sheet {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }

            .page-break-inside-avoid {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="py-8 antialiased">

    <!-- Screen Navigation & Action Bar (Hidden during Print / PDF generation) -->
    <header class="no-print max-w-4xl mx-auto mb-6 px-4 flex items-center justify-between">
        <a href="{{ route('checkout.confirmation', $order->order_number) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-black transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back to Confirmation</span>
        </a>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-zinc-800 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print / Save as PDF</span>
            </button>
        </div>
    </header>

    <!-- Main Printable Invoice Sheet -->
    <main class="invoice-sheet max-w-4xl mx-auto bg-white rounded-xl shadow-2xl p-10 sm:p-14 border border-zinc-200 text-zinc-800 relative">
        
        <!-- Subtle Top Gold Accent Line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-700 via-amber-400 to-amber-600 mb-8 rounded-full"></div>

        <!-- Header: Brand Identity & Document Type -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-8 border-b border-zinc-200">
            <div>
                <div class="font-luxury-brand text-3xl font-extrabold tracking-[0.25em] text-zinc-950">
                    ATELIER ÉLITE
                </div>
                <div class="text-[10px] uppercase tracking-[0.35em] text-amber-800 font-semibold mt-1">
                    Maison de Haute Prêt-à-Porter • Fondée à Milan
                </div>
                <div class="text-xs text-zinc-500 mt-2 space-y-0.5 font-light">
                    <p>Via Monte Napoleone, 8 • 20121 Milano, Italy</p>
                    <p>concierge@atelier-elite.com • +39 02 8901 3400</p>
                </div>
            </div>

            <div class="text-left sm:text-right space-y-1">
                <div class="inline-block px-3 py-1 bg-amber-50 border border-amber-300 text-amber-900 text-[11px] font-bold uppercase tracking-widest rounded mb-2">
                    Official Invoice
                </div>
                <div class="text-xs text-zinc-500 font-medium">
                    Invoice No: <span class="font-mono font-bold text-zinc-900">INV-{{ str_replace('ORD-', '', $order->order_number) }}</span>
                </div>
                <div class="text-xs text-zinc-500">
                    Order Ref: <span class="font-mono text-zinc-800">{{ $order->order_number }}</span>
                </div>
                <div class="text-xs text-zinc-500">
                    Date of Issue: <span class="font-semibold text-zinc-900">{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="text-xs text-zinc-500">
                    Fulfillment: <span class="font-semibold text-zinc-900 uppercase">{{ $order->order_status }}</span>
                </div>
            </div>
        </div>

        <!-- Client & Consignee Information -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-zinc-200 text-xs">
            <div>
                <h2 class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold mb-2">Billed To (Client)</h2>
                <div class="space-y-1 text-zinc-700">
                    <p class="font-bold text-sm text-zinc-950 font-luxury-serif">{{ $order->customer_name }}</p>
                    <p class="text-zinc-600">{{ $order->customer_email }}</p>
                    @if ($order->customer_phone)
                        <p class="text-zinc-600">Tel: {{ $order->customer_phone }}</p>
                    @endif
                    <div class="pt-2 flex flex-col gap-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 font-medium text-[11px]">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Payment: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} ({{ ucfirst($order->payment_status) }})
                        </span>
                        @if ($order->transaction_id)
                            <span class="text-[10px] text-zinc-500 font-mono">
                                Gateway Ref: <strong class="text-zinc-800">{{ $order->transaction_id }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold mb-2">Shipped To (Destination)</h2>
                <div class="space-y-1 text-zinc-700">
                    <p class="font-bold text-sm text-zinc-950 font-luxury-serif">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    <p class="font-semibold">{{ $order->shipping_country }}</p>
                    <p class="text-[11px] text-zinc-500 pt-1">Dispatch Method: <strong class="text-zinc-800">White-Glove Global Air Express</strong></p>
                </div>
            </div>
        </div>

        <!-- Garments Itemized Table -->
        <div class="py-6 page-break-inside-avoid">
            <h2 class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold mb-4">Acquisition Register</h2>
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b-2 border-zinc-900 text-[10px] uppercase tracking-wider text-zinc-500 font-semibold">
                        <th class="py-3 pr-2 w-10 text-center">#</th>
                        <th class="py-3 px-2">Garment Description</th>
                        <th class="py-3 px-2 w-28 text-center">SKU</th>
                        <th class="py-3 px-2 w-16 text-center">Qty</th>
                        <th class="py-3 px-2 w-24 text-right">Unit Price</th>
                        <th class="py-3 pl-2 w-28 text-right">Valuation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @foreach ($order->items as $index => $item)
                        <tr class="align-top">
                            <td class="py-4 pr-2 text-center text-zinc-400 font-mono text-[11px]">{{ $index + 1 }}</td>
                            <td class="py-4 px-2">
                                <div class="font-bold text-zinc-900 text-sm font-luxury-serif">{{ $item->product_name }}</div>
                                @if ($item->product && $item->product->specs)
                                    <div class="text-[11px] text-zinc-500 mt-0.5 line-clamp-1">
                                        {{ $item->product->short_description }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-2 text-center font-mono text-[11px] text-zinc-600">{{ $item->product_sku }}</td>
                            <td class="py-4 px-2 text-center font-bold text-zinc-800">{{ $item->quantity }}</td>
                            <td class="py-4 px-2 text-right font-mono text-zinc-700">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-4 pl-2 text-right font-mono font-bold text-zinc-950">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Financial Totals Section -->
        <div class="pt-4 border-t-2 border-zinc-900 flex flex-col sm:flex-row justify-between items-start gap-6 page-break-inside-avoid">
            <!-- Left: Craftsmanship Guarantee & Signature -->
            <div class="sm:max-w-xs space-y-3">
                <div class="p-3 bg-amber-50/50 rounded-lg border border-amber-200/60 text-[11px] text-amber-950 leading-relaxed">
                    <span class="font-bold block uppercase tracking-wider text-[10px] text-amber-900 mb-0.5">Certificate of Provenance</span>
                    Every piece is crafted in European artisanal workshops and verified by Atelier Élite's Master Tailor before dispatch.
                </div>

                @if ($order->notes)
                    <div class="text-[11px] text-zinc-600">
                        <strong class="text-zinc-900 font-semibold block">Delivery Instructions:</strong>
                        {{ $order->notes }}
                    </div>
                @endif
            </div>

            <!-- Right: Subtotal, Shipping, Tax, Grand Total -->
            <div class="w-full sm:w-72 space-y-2 text-xs">
                <div class="flex justify-between text-zinc-600">
                    <span>Garments Subtotal:</span>
                    <span class="font-mono text-zinc-900">${{ number_format($order->subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between text-zinc-600">
                    <span>Express Air Courier:</span>
                    @if ($order->shipping_cost == 0)
                        <span class="font-bold text-emerald-700 uppercase tracking-wider text-[11px]">Complimentary ($0.00)</span>
                    @else
                        <span class="font-mono text-zinc-900">${{ number_format($order->shipping_cost, 2) }}</span>
                    @endif
                </div>

                <div class="flex justify-between text-zinc-600">
                    <span>Duties & Taxes (8%):</span>
                    <span class="font-mono text-zinc-900">${{ number_format($order->tax, 2) }}</span>
                </div>

                <div class="pt-3 border-t border-zinc-300 flex justify-between items-baseline text-base font-bold text-zinc-950">
                    <span>Grand Total:</span>
                    <span class="text-xl font-bold font-luxury-serif text-amber-900 font-mono">${{ number_format($order->total, 2) }}</span>
                </div>

                <div class="pt-1 text-right text-[10px] text-zinc-500 uppercase tracking-widest font-semibold">
                    Amount Paid in Full
                </div>
            </div>
        </div>

        <!-- Footer / Authenticity Seal -->
        <div class="mt-12 pt-6 border-t border-zinc-200 flex flex-col sm:flex-row items-center justify-between text-[10px] text-zinc-500 gap-4 page-break-inside-avoid">
            <div>
                <p class="font-semibold text-zinc-700">ATELIER ÉLITE MAISON DE COUTURE</p>
                <p>Tax Registration: IT-0928410294 • Certified Authentic Garments</p>
            </div>
            <div class="text-right">
                <p>Thank you for choosing artisanal sartorial excellence.</p>
                <p>30-Day Bespoke Returns • concierge@atelier-elite.com</p>
            </div>
        </div>
    </main>

</body>
</html>
