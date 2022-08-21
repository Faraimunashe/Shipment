<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order</title>
</head>
<body>
    <h1 style="align-content: center"> Order Report</h1>
    <h3><strong>Username: </strong>{{ Auth::user()->name }}</h3>
    <h3><strong>Email: </strong>{{ Auth::user()->email }}</h3>
    <h3><strong>Order #: </strong>{{ $order->code }}</h3>
    <h3><strong>Status: </strong>{{ $order->status }}</h3>
    Order Items:
    <table class="table table-striped">
        <thead>
          <th>#</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Total Price</th>
        </thead>
        <tbody>
            @php
                                    $count = 0;
                                @endphp
          @foreach($items as $item)
          <tr>
            <th scope="row">
                @php
                    $count++;
                    echo $count;
                @endphp
            </th>
            <td>{{$item->product_name}}</td>
            <td>{{$item->qty}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->total}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Sub Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->sub_total}}</td>
            </tr>
            <tr>
                <td>Consignor Fee</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->consigner_fee}}</td>
            </tr>
            <tr>
                <td><b>Grand Total</b></td>
                <td><b></b></td>
                <td></td>
                <td><b></b></td>
                <td><b>{{$order->total}}</b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
