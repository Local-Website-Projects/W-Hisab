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
        <th>Product Name</th>
        <th>Supplier Name</th>
        <th>Note</th>
        <th>Credit Amount</th>
        <th>Debit Amount</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_debit_amount = 0;
        $total_credit_amount = 0;
    @endphp
    <tr>
        <td colspan="6" style="font-weight: bold;">Cash in Hand</td>
        <td style="font-weight: bold;">{{$cashOnHand}}</td>
        <td></td>
    </tr>
    @forelse($cashbooks as $index => $cashbook)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($cashbook->date)->format('d M, Y') }}</td>
            <td>{{ $cashbook->project->project_name }}</td>
            <td>{{ optional($cashbook->product)->product_name ?? 'N/A' }}</td>
            <td>{{ optional($cashbook->supplier)->supplier_name ?? 'N/A'}}</td>
            <td>{{ $cashbook->note }}</td>
            <td>{{ $cashbook->credit }}</td>
            <td>{{ $cashbook->debit }}</td>
            @php
                $total_debit_amount += $cashbook->debit;
                $total_credit_amount += $cashbook->credit;
            @endphp
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No data found for selected date range.</td>
        </tr>
    @endforelse
    <tr>
        <td colspan="6" style="font-weight: bold;">Total</td>
        <td style="font-weight: bold;">{{$total_credit_amount + $cashOnHand}}</td>
        <td style="font-weight: bold;">{{$total_debit_amount}}</td>
    </tr>
    </tbody>
</table>

<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
