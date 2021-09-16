<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Order Date : {{$order->order_date}} {{$order->order_time}}</h2>
<h2>Order Number : #{{$order->order_number}}</h2>
<table>
  <tr>
    <th>Item</th>
    <th>Price</th>
  </tr>
  @php
    $total=0;
  @endphp
  @foreach ($order->orderItems as $item)
  @php
  $total=$total+$item->menu_total;
  @endphp
  <tr>
    <td>{{$item->menu_name}} (${{$item->menu_total}} </span> X {{$item->menu_qty}}) </td>
    <td>${{$item->menu_total * $item->menu_qty}}</td>
  </tr>
  @endforeach
  
  </tfoot>
  <tr>
    <th>Cart Charge
    <th>${{$order->cart_charge}}
  </tr>
  <tr>
    <th>Delivery Charge
    <th>${{$order->delivery_charge}}
  </tr>
  <tr>
    <th>Total Discount
    <th>${{$order->discount_charge}}
  </tr>
  <tr>
    <th>Total
    <th>${{$order->grand_total}}
  </tr>
  
  </tfoot>
  </table>

</body>
</html>
