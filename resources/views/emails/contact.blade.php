@component('mail::message')

<h1 style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: center;">
    Welcome to {{ config('app.name') }}
</h1>

### Dear Admin,

We are Happy to see you here. 

You have below message.

<p>Name : {{$data->name}} </p>
<p>Subject : {{$data->subject}}</p>
<p>Description : {{$data->description}}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
