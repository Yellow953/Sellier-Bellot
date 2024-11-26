<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2,
        h3 {
            margin: 5px 0;
        }

        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .header-table td {
            vertical-align: top;
        }

        .section-table {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .section-table td {
            vertical-align: top;
        }

        .total {
            font-weight: bold;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <img src="{{ public_path('assets/images/logo.png') }}" alt="Logo" style="width: 150px;">
            </td>
            <td style="width: 50%; text-align: right;">
                <h2>Daily Report</h2>
                <p><b>Date:</b> {{ $date }}</p>
            </td>
        </tr>
    </table>

    <!-- Items Section -->
    <table class="section-table" style="margin: 0; padding: 0;">
        <tr>
            <td style="width: 33%; padding: 0;">
                <h3>Calibers</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Brass</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($caliber_analysis as $caliber)
                        <tr>
                            <td>{{ $caliber['name'] }}</td>
                            <td>{{ $caliber['quantity'] }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width: 33%; padding: 0;">
                <h3>Lanes</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lane_analysis as $lane)
                        <tr>
                            <td>{{ $lane['name'] }}</td>
                            <td>{{ $lane['quantity'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width: 33%; padding: 0;">
                <h3>Pistols</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pistol_analysis as $pistol)
                        <tr>
                            <td>{{ $pistol['name'] }}</td>
                            <td>{{ $pistol['quantity'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <table class="header-table">
        <tr>
            <td>
                <!-- Summary Section -->
                <div>
                    <h3>Total Revenue</h3>
                    <p class="total">Total: ${{ number_format($total_money, 2) }}</p>
                </div>
            </td>
            <td>
                <!-- Signature Section -->
                <div class="signature">
                    <p>__________________________</p>
                    <p>Signature</p>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>