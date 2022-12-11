<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Test Mail</h1>
    <h1>{{ $data['content'] }}</h1>
    <h1>Name: {{$data['name'] }}</h1>
    <h1>Email : {{$data['email'] }}</h1>
    <h1>Order Total: {{$data['order_total'] }}</h1>
    <table style="border: 1px solid gray">
        <tr>
            <th>STT</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Price Total</th>
        </tr>
        @php $total = 0; @endphp
        @foreach ($data['order_products'] as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['qty'] }}</td>
                <td>{{ $product['price'] }}</td>

                @php
                    $totalRow = $product['qty'] * $product['price'];
                    $total += $totalRow;
                @endphp

                <td>{{ number_format($totalRow, 2) }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
