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
    </style>
</head>
<body class="p-4">

<div class="no-print text-end mb-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

<h2 class="text-center mb-4">Profile Report</h2>
<p><strong>From:</strong> {{ \Carbon\Carbon::parse($fromDate)->format('d M, Y') }}</p>
<p><strong>To:</strong> {{ \Carbon\Carbon::parse($toDate)->format('d M, Y') }}</p>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Note</th>
        <th>Deposit Amount</th>
        <th>Expense Amount</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_deposit_amount = 0;
        $total_expense_amount = 0;
    @endphp
    @forelse($profiles as $index => $profile)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($profile->date)->format('d M, Y') }}</td>
            <td>{{ $profile->note }}</td>
            <td>{{ $profile->deposit_amount }}</td>
            <td>{{ $profile->expense_amount }}</td>
            @php
            $total_deposit_amount += $profile->deposit_amount;
            $total_expense_amount += $profile->expense_amount;
            @endphp

        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No data found for selected date range.</td>
        </tr>
    @endforelse
    <tr>
        <td colspan="3">Total</td>
        <td>{{$total_deposit_amount}}</td>
        <td>{{$total_expense_amount}}</td>
    </tr>
    </tbody>
</table>

<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
