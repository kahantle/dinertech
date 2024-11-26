@component('mail::message')

    <h1 style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: center;">
        Activate {{ config('app.name') }} Account
    </h1>
    <h3>Dear {{$data['user']->first_name}} {{$data['user']->last_name}},</h3>
    <p>{{$data['messages']}}</p>

    Thanks,
    {{ config('app.name') }}
@endcomponent
