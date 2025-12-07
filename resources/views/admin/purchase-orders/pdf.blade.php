<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la orden de compra</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #222
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .section {
            margin-top: 20px;
        }

        @font-face {
            font-family: 'DejaVu Sans';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/fonts/Roboto-Regular.ttf') format('truetype');
        }
    </style>
</head>
<body>
    <div class="title">Detalle de compra #{{ $purchaseOrder->serie }}-{{ str_pad($purchaseOrder->correlative, 4, '0', STR_PAD_LEFT) }}</div>
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