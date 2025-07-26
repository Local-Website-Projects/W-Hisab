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

<h2 class="text-center mb-4">Project: {{ $project->project_name }}</h2>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Supplier Name</th>
        <th>Credit</th>
        <th>Debit</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_debit = 0;
        $total_credit = 0;
    @endphp
    @forelse($cashbooks as $index => $cashbook)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ optional ($cashbook->supplier)->supplier_name ?? 'N/A' }}</td>
            <td>{{ $cashbook->total_credit }}</td>
            <td>{{ $cashbook->total_debit }}</td>
            @php
                $total_debit += $cashbook->total_debit;
                $total_credit += $cashbook->total_credit;
            @endphp

        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No data found for selected date range.</td>
        </tr>
    @endforelse
    <tr>
        <td colspan="2">Total</td>
        <td>{{$total_credit}}</td>
        <td>{{$total_debit}}</td>
    </tr>
    </tbody>
</table>

<div class="no-print text-end mt-3">
    <button onclick="window.print()" class="btn btn-primary">Print Report</button>
</div>

</body>
</html>
