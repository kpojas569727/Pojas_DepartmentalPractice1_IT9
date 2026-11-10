<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 4px; }
        p { text-align: center; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <p>Generated: {{ now()->format('F d, Y h:i A') }} | Records: {{ $plants->count() }}</p>

    <table>
        <thead>
            <tr><th>Name</th><th>Category</th><th>Unit Price</th><th>Stock</th></tr>
        </thead>
        <tbody>
            @foreach ($plants as $plant)
                <tr>
                    <td>{{ $plant->name }}</td>
                    <td>{{ ucfirst($plant->category) }}</td>
                    <td>{{ number_format($plant->unit_price, 2) }}</td>
                    <td>{{ $plant->stock_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>