<!DOCTYPE html>
<html>
<head>
    <title>Expenses Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Expenses Report</h2>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Expense Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->description }}</td>
                <td>{{ ucfirst($expense->category) }}</td>
                <td>₱{{ number_format($expense->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                <td>{{ $expense->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
