@component('mail::message')

### Dear Restaurant,


<p>Name : {!! $data['customer_name'] !!} </p>
<p>Phone : {!! $data['customer_phone'] !!} </p>
<p>Message : {!! $data['message'] !!}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
