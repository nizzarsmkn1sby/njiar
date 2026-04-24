<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $transaction->invoice_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
            width: 300px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .logo {
            font-weight: 900;
            font-size: 20px;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .info {
            margin-bottom: 15px;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }
        .info div {
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            padding: 5px 0;
        }
        .footer {
            border-top: 2px dashed #000;
            padding-top: 15px;
            margin-top: 15px;
            text-align: center;
        }
        .total-row {
            font-weight: 900;
            font-size: 14px;
        }
        .sub-total-row {
            font-weight: 700;
            font-size: 10px;
            opacity: 0.7;
        }
        @media print {
            body { padding: 0; margin: 0; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div class="logo">NIJAR<span style="opacity: 0.4">POS</span></div>
        <div style="font-size: 10px; opacity: 0.6; margin-top: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">Receipt</div>
        <div style="font-size: 8px; opacity: 0.4; margin-top: 4px;">Surabaya, Indonesia</div>
    </div>

    <div class="info">

        <div><span>Date</span> <span>{{ date('d M Y, H:i', strtotime($transaction->transaction_date)) }}</span></div>
        <div><span>Cashier</span> <span>{{ $transaction->user->name }}</span></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center">Qty</th>
                <th style="text-align: right">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td style="font-weight: 700">{{ $detail->product->name ?? 'Deleted Product' }}</td>
                <td style="text-align: center">{{ $detail->qty }}</td>
                <td style="text-align: right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="info" style="border-top: 1px solid #000; padding-top: 10px">
        <div class="sub-total-row"><span>Subtotal</span> <span>{{ number_format($transaction->total_price * 0.9, 0, ',', '.') }}</span></div>
        <div class="sub-total-row"><span>Tax (10%)</span> <span>{{ number_format($transaction->total_price * 0.1, 0, ',', '.') }}</span></div>
        <div class="total-row" style="margin-top: 8px; border-top: 2px solid #000; padding-top: 8px"><span>TOTAL</span> <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></div>
        <div style="margin-top: 10px; opacity: 0.6"><span>Pay</span> <span>Rp {{ number_format($transaction->pay, 0, ',', '.') }}</span></div>
        <div style="opacity: 0.6"><span>Change</span> <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span></div>
    </div>

    <div class="footer">
        <div style="font-weight: 800; text-transform: uppercase; font-size: 10px; letter-spacing: 1px;">Thank You!</div>
        <div style="font-size: 8px; opacity: 0.5; margin-top: 5px;">Powered by Nijar POS System</div>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.close()" style="padding: 10px 20px; background: #000; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Close Window</button>
    </div>
</body>
</html>
