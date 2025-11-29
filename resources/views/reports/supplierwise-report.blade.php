<!DOCTYPE html>
<html>
<head>
    <title>Projectwise Cashbook Report</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
        *{
            font-size:12px !important;
        }
    </style>
</head>
<body class="p-4">

<div class="no-print text-end mb-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

<h1 class="text-center mb-4" style="font-size: 20px !important;">Supplier: {{ $name->supplier_name }}</h1>

<table class="table table-bordered mt-3">
    <thead>
    <tr class="text-center">
        <th colspan="6">Purchase Order</th>
        <th colspan="4">Paid Amounts</th>
    </tr>
    <tr>
        <th>Sl No</th>
        <th>Date</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>

        <th>Sl No</th>
        <th>Date</th>
        <th>Note</th>
        <th>Amount</th>
    </tr>
    </thead>

    <tbody>
    @php
        $purchases = $supplier->purchases;
        $payments = $supplier->payments;

        $maxRows = max($purchases->count(), $payments->count());
    @endphp

    @for ($i = 0; $i < $maxRows; $i++)
        <tr>
            {{-- Purchases --}}
            @if(isset($purchases[$i]))
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($purchases[$i]->created_at)->format('d M, Y') }}</td>
                <td>{{ $purchases[$i]->product->product_name ?? 'N/A' }}</td>
                <td>{{ $purchases[$i]->quantity }} {{ $purchases[$i]->unit }}</td>
                <td>{{ formatBDT($purchases[$i]->unit_price) }}</td>
                <td>{{ formatBDT($purchases[$i]->total_price) }}</td>
            @else
                <td colspan="6" class="text-center">—</td>
            @endif


            {{-- Payments --}}
            @if(isset($payments[$i]))
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($payments[$i]->date)->format('d M, Y') }}</td>
                <td>{{ $payments[$i]->note }}</td>
                <td>{{ formatBDT($payments[$i]->debit) }}</td>
            @else
                <td colspan="4" class="text-center">—</td>
            @endif
        </tr>
    @endfor


    {{-- Total Row --}}
    <tr style="font-weight: bold; background:#e9ecef;">
        <td colspan="5" class="text-right">
            Total Purchases:
        </td>
        <td class="text-left">
            {{ formatBDT($purchases->sum('total_price')) }}
        </td>
        <td colspan="3" class="text-right">
            Total Paid:
        </td>
        <td class="text-left">
            {{ formatBDT($payments->sum('debit')) }}
        </td>
    </tr>

    {{-- Profit/Loss Row --}}
    @php
        $totalPaid = $payments->sum('debit');
        $totalPurchase = $purchases->sum('total_price');
    @endphp
    <tr style="font-weight: bold; background:#d6ffd6;">
        <td colspan="10" class="text-center">
            {{ $totalPaid >= $totalPurchase ? 'Advance Payment to Supplier: ' : 'Payable to Supplier: ' }} {{ formatBDT(abs($totalPaid - $totalPurchase)) }}
        </td>
    </tr>
    </tbody>
</table>

<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
