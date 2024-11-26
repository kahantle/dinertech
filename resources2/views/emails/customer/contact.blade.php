@component('mail::message')

    ### Dear Restaurant,

    <p>Name : {{ $data['customer_name'] }} </p>
    <p>Message : {{ $data['message'] }}</p>


    Thanks,<br>
    {{ config('app.name') }}

@endcomponent
