<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .total {
            font-weight: bold;
        }

        .signature {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Daily Report</h2>
    <p>Date: {{ $date }}</p>

    <h3>Transaction Summary</h3>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Transaction Date</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->customer->name }}</td>
                <td>{{ $transaction->transaction_date }}</td>
                <td>${{ number_format($transaction->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Items Used</h3>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Calibers</td>
                <td>{{ $calibers_total }}</td>
                <td>${{ number_format($calibers->sum('total_price'), 2) }}</td>
            </tr>
            <tr>
                <td>Lanes</td>
                <td>{{ $lanes_total }}</td>
                <td>${{ number_format($lanes->sum('total_price'), 2) }}</td>
            </tr>
            <tr>
                <td>Pistols</td>
                <td>{{ $pistols_total }}</td>
                <td>${{ number_format($pistols->sum('total_price'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Items Analysis</h3>

    <h4>Calibers</h4>
    <table>
        <thead>
            <tr>
                <th>Caliber</th>
                <th>Quantity Used</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($caliber_analysis as $caliber)
            <tr>
                <td>{{ $caliber['name'] }}</td>
                <td>{{ $caliber['quantity'] }}</td>
                <td>${{ number_format($caliber['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Lanes</h4>
    <table>
        <thead>
            <tr>
                <th>Lane</th>
                <th>Times Used</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lane_analysis as $lane)
            <tr>
                <td>{{ $lane['name'] }}</td>
                <td>{{ $lane['quantity'] }}</td>
                <td>${{ number_format($lane['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Pistols</h4>
    <table>
        <thead>
            <tr>
                <th>Pistol</th>
                <th>Times Used</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pistol_analysis as $pistol)
            <tr>
                <td>{{ $pistol['name'] }}</td>
                <td>{{ $pistol['quantity'] }}</td>
                <td>${{ number_format($pistol['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Revenue</h3>
    <p class="total">Total: ${{ number_format($total_money, 2) }}</p>

    <div class="signature">
        <p>__________________________</p>
        <p>Signature</p>
    </div>
</body>

</html>