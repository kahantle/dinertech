<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="format-detection" content="telephone=no" />
    <link rel="shortcut icon" type="image/x-icon" href="images/default-favicon.ico">
    <title>Dinertech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'IBM Plex Mono', monospace;font-size:16px;display: flex;align-items: center;width: 100%;height: 100vh;padding:0;margin:0">
	<div style="margin: auto;width: 400px;position:relative;padding: 30px 0">
		<div style="width:100%;text-align:center;">
			<img src="{{ asset('assets/images/logo_wide.png') }}" width="280" />
		</div>
		<p style="text-align:center;">{{$restaurant->restaurant_name}}</p>
		<p style="text-align: center;margin: 0;">{{$restaurant->phone}}</p>
		<p style="text-align: center;margin: 0;">{{$user ->mobile_number}}</p>
		<p style="text-align: center;margin-top: 0;">{{$restaurant->restaurant_address}}  </p>
		<p style="text-align: center;margin-top:0;">STORE DIRECTOR - Datpitch Technologies</p>
		<p style="text-align: center;margin: 0;">Invoice Date & Time {{$order->order_date}} {{$order->order_time}}</p>
		<p style="text-align: center;margin: 0;">Invoice & Order Number : {{$order->order_number}}</p>
		<table style="width: 350px;margin: 10px auto;border-top: 1px dashed #000;border-bottom: 1px dashed #000;">
			<tbody>
		  @foreach ($order->orderItems as $key=>$item)
      <tr>
        <td style="">{{$key+1}}</td>
        <td style="width: 150px;">{{$item->menu_name}}</td>
        <td style="text-align:right;">${{$item->menu_total}}</td>
      </tr>
      @endforeach
			</tbody>
		</table>
		<table style="width: 350px;margin: 10px auto;">
			<tbody>
				<tr>
					<td style="">Cart Charges</td>
					<td style="text-align:right;">${{number_format($order->cart_charge,2)}}</td>
				</tr>
				<tr>
					<td style="">Dilivery Charges</td>
					<td style="text-align:right;">${{number_format($order->delivery_charge,2)}}</td>
				</tr>
				<tr>
					<td style="">Total Discount</td>
					<td style="text-align:right;">${{number_format($order->discount_charge,2)}}</td>
				</tr>
				<tr style="font-size:30px;">
					<td style="">Total</td>
					<td style="text-align:right;">${{number_format($order->grand_total,2)}}</td>
				</tr>
			</tbody>
		</table>
		<p style="width: 350px;text-align: center; margin-left:auto;margin-right:auto;border-top: 1px dashed #000;padding-top:10px">Purchased item total number Sign Up and Save ! With Preffered Saving Card</p>
		<div style="text-align: center;">
			<img src="{{ asset('assets/images/barcode.jpg') }}">
		</div>
	</div>
</body>
</html>