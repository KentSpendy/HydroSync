<!DOCTYPE html>
<html>
<head>
    <title>Transactions Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Transactions Report</h2>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Group</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->customer_name }}</td>
                <td>₱{{ number_format($transaction->amount, 2) }}</td>
                <td>{{ ucfirst($transaction->payment_status) }}</td>
                <td>{{ $transaction->delivery_group ?? '-' }}</td>
                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
