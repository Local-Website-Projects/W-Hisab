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

<h2 class="text-center mb-4" style="font-size: 24px !important;">Project: {{$projectName }}</h2>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Purchaser/Supplier Name</th>
        <th>Credit (Payable)</th>
        <th>Debit (Receivable)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_debit = 0;
        $total_credit = 0;
    @endphp

    @forelse($balance_sheets as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>

            {{-- If you only have supplier_id --}}
            <td>{{ $row['supplier_name'] }}</td>

            <td>{{ formatBDT($row['payable'], 0) }}</td>
            <td>{{ formatBDT($row['receivable'], 0) }}</td>

            @php
                $total_credit += $row['payable'];     // credit column → payable
                $total_debit  += $row['receivable'];  // debit column → receivable
            @endphp
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No data found for selected date range.</td>
        </tr>
    @endforelse
    <tr>
        @if($total_debit > $total_credit)
            @php $profit = $total_debit - $total_credit; @endphp
            <td></td>
            <td>Cash In Hand</td>
            <td>{{ formatBDT($profit, 0) }}</td>
            <td></td>
            @php $total_credit += $profit; @endphp

        @elseif($total_debit < $total_credit)
            @php $loss = $total_credit - $total_debit; @endphp
            <td></td>
            <td>Cash In Hand</td>
            <td></td>
            <td>{{ formatBDT($loss, 0) }}</td>
            @php $total_debit += $loss; @endphp

        @else
            <td></td>
            <td>Profit/Loss</td>
            <td>0</td>
            <td>0</td>
        @endif
    </tr>
    <tr class="fw-bold">
        <td colspan="2" class="text-end">Total:</td>
        <td>{{ formatBDT($total_credit, 0) }}</td>
        <td>{{ formatBDT($total_debit, 0) }}</td>
    </tr>
    </tbody>
</table>


<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
