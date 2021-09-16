<!DOCTYPE html>
<html>
<body>
    <h3>Order Number : {{$orderId}}</h3>
    <h3>Restaurant : {{$restaurant->restaurant_name}}</h3>
    <h3>Customer Name : {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
    <h3>Date / Time : {{date('M d,h:i a')}}</h3>

    <table style="width: 100%">
        <tr>
            <th style="border: 1px solid #000">Customer</th>
            <th style="border: 1px solid #000">Order Number</th>
            <th style="border: 1px solid #000">Sent From</th>
            <th style="border: 1px solid #000">Message</th>
        </tr>
        @foreach ($chats as $chat)
            <tr>
                <td style="border: 1px solid #000;text-align:center;">{{$chat['full_name']}}</td>
                <td style="border: 1px solid #000;text-align:center;">{{$chat['order_number']}}</td>
                <td style="border: 1px solid #000;text-align:center;">{{$chat['sent_from']}}</td>
                <td style="border: 1px solid #000">{{$chat['message']}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>