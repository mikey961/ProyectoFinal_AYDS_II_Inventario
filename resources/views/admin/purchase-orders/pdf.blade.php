<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la orden de compra</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 25px;
            color: #333;
            line-height: 1.4;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ccc;
        }

        .section {
            margin-top: 25px;
            padding: 15px;
            background: #fafafa;
            border-radius: 8px;
            border: 1px solid #e3e3e3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
            border-bottom: 2px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        td {
            border-bottom: 1px solid #e6e6e6;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-box {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="title">Detalle de la orden de compra #{{ $purchaseOrder->serie }}-{{ str_pad($purchaseOrder->correlative, 4, '0', STR_PAD_LEFT) }}</div>
    <div>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($purchaseOrder->date)->format('d/m/Y') }}<br>
        <strong>Proveedor:</strong> {{ $purchaseOrder->supplier->name ?? '_'}}<br>
        <strong>Observación:</strong> {{ $purchaseOrder->observation ?? '_' }}
    </div>
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->product as $i => $products)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $products->name }}</td>
                        <td>{{ $products->pivot->quantity }}</td>
                        <td>₡ {{ number_format($products->pivot->price, 2) }}</td>
                        <td>₡ {{ number_format($products->pivot->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="section"
        style="text-align: right;">
        <strong>
            Total: ₡ {{ number_format($purchaseOrder->total, 2) }}
        </strong>
    </div>
</body>
</html>