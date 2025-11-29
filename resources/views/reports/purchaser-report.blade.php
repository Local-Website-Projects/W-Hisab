<!DOCTYPE html>
<html>
<head>
    <title>Purchaser Report</title>
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

<h1 class="text-center mb-4" style="font-size: 20px !important;">Purchaser: {{ $name->supplier_name }}</h1>

<table class="table table-bordered mt-3">
    <thead>
    <tr class="text-center">
        <th colspan="5">Flat Purchase</th>
        <th colspan="4">Paid Amounts</th>
    </tr>
    <tr>
        <th>Sl No</th>
        <th>Date</th>
        <th>Project Name</th>
        <th>Note</th>
        <th>Total Price</th>

        <th>Sl No</th>
        <th>Date</th>
        <th>Note</th>
        <th>Amount</th>
    </tr>
    </thead>

    <tbody>
    @php
        $purchases = $supplier->flatsell;
        $payments = $supplier->payments;
        $maxRows = max($purchases->count(), $payments->count());
    @endphp

    @for ($i = 0; $i < $maxRows; $i++)
        <tr>
            {{-- Purchases --}}
            @if(isset($purchases[$i]))
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($purchases[$i]->date)->format('d M, Y') }}</td>
                <td>{{ $purchases[$i]->project->project_name ?? 'N/A' }}</td>
                <td>{{ $purchases[$i]->note ?? '—' }}</td>
                <td>{{ formatBDT($purchases[$i]->total_amount) }}</td>
            @else
                <td colspan="5" class="text-center">—</td>
            @endif

            {{-- Payments --}}
            @if(isset($payments[$i]))
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($payments[$i]->date)->format('d M, Y') }}</td>
                <td>{{ $payments[$i]->note ?? '—' }}</td>
                <td>{{ formatBDT($payments[$i]->credit) }}</td>
            @else
                <td colspan="4" class="text-center">—</td>
            @endif
        </tr>
    @endfor

    {{-- Total Row --}}
    @php
        $totalPurchase = $purchases->sum('total_amount');
        $totalPaid = $payments->sum('credit');
    @endphp
    <tr style="font-weight: bold; background:#e9ecef;">
        <td colspan="4" class="text-right">Total Purchases:</td>
        <td>{{ formatBDT($totalPurchase) }}</td>

        <td colspan="3" class="text-right">Total Paid:</td>
        <td>{{ formatBDT($totalPaid) }}</td>
    </tr>

    {{-- Remaining / Advance Row --}}
    <tr style="font-weight: bold; background:#d6ffd6;">
        <td colspan="9" class="text-center">
            @if($totalPaid >= $totalPurchase)
                Payable to Purchaser: {{ formatBDT($totalPaid - $totalPurchase) }}
            @else
                Receivable from Purchaser: {{ formatBDT($totalPurchase - $totalPaid) }}
            @endif
        </td>
    </tr>
    </tbody>
</table>


<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
