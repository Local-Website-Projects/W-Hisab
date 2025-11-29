<!DOCTYPE html>
<html>
<head>
    <title>Datewise Profile Report</title>
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

<h2 class="text-center mb-4">Cash Book Report</h2>
<p><strong>From:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }}</p>
<p><strong>To:</strong> {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</p>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Project Name</th>
        <th>Supplier Name</th>
        <th>Note</th>
        <th class="text-end">Credit Amount</th>
        <th class="text-end">Debit Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: right;">Previous Balance</td>
        <td style="font-weight: bold; text-align: right;">{{ formatBDT($openingBalance) }}</td>
        <td></td>
    </tr>
    @php
        // Use floats and ensure nulls become 0
        $total_debit_amount = 0.0;
        $total_credit_amount = 0.0;
    @endphp

    @forelse($cashbooks as $index => $cashbook)
        @php
            // make sure values are numeric
            $credit = $cashbook->credit !== null ? (float) $cashbook->credit : 0.0;
            $debit  = $cashbook->debit  !== null ? (float) $cashbook->debit  : 0.0;

            $total_debit_amount  += $debit;
            $total_credit_amount += $credit;
        @endphp

        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($cashbook->date)->format('d M, Y') }}</td>
            <td>{{ $cashbook->project->project_name ?? 'N/A' }}</td>
            <td>{{ optional($cashbook->supplier)->supplier_name ?? 'N/A' }}</td>
            <td>{{ $cashbook->note }}</td>
            <td class="text-end">{{ $credit ? formatBDT($credit) : '' }}</td>
            <td class="text-end">{{ $debit ? formatBDT($debit) : '' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No data found for selected date range.</td>
        </tr>
    @endforelse

    {{-- Totals row: show only the summed credits & debits (do not add cashOnHand here) --}}
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: right;">Total (Period)</td>
        <td style="font-weight: bold; text-align: right;">{{ formatBDT($total_credit_amount + $openingBalance)  }}</td>
        <td style="font-weight: bold; text-align: right;">{{ formatBDT($total_debit_amount) }}</td>
    </tr>

    {{-- Cash in Hand (closing) --}}
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: right;">Cash in Hand</td>
        <td style="font-weight: bold; text-align: right;">{{ formatBDT($cashOnHand) }}</td>
    </tr>
    </tbody>
</table>


<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
