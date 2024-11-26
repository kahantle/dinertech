{{-- <ul>
    @forelse ($chats as $chat)
        @if ($chat['sent_from'] == 'RESTAURANT')
            <li class="sent">
                <img src="{{asset('assets/customer/images/Logo-Round.png')}}" alt="" />
                <p>
                    {{$chat['message']}}
                    @php
                        $messageTime = explode(' ',$chat['message_date']);
                    @endphp
                    <span>{{date('h:i A',strtotime($messageTime[1]))}}</span>
                </p>
            </li>        
        @endif
        @if ($chat['sent_from'] == 'CUSTOMER')
            <li class="replies">
                @empty(Auth::user()->profile_image)
                    <img src="{{asset('assets/customer/images/user-small.png')}}" alt="user_image" />
                @else
                    <img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),Auth::user()->profile_image])}}" alt="user_image" />
                @endempty
                <p>
                    {{$chat['message']}}
                    @php
                        $messageTime = explode(' ',$chat['message_date']);
                    @endphp
                    <span>{{date('h:i A',strtotime($messageTime[1]))}}</span>
                </p>
            </li>            
        @endif
    @empty
            
    @endforelse
</ul> --}}
<ul>
    @forelse ($chats as $chat)
        @if ($chat['sent_from'] == 'RESTAURANT')
            @php
                $messageTime = explode(' ', $chat['message_date']);
            @endphp
            <li class="sent">
                <img src="{{ asset('assets/customer/images/Logo-Round.png') }}" class="img-fluid">
                <p>
                    {{ $chat['message'] }}
                    <span>{{ date('h:i A', strtotime($messageTime[1])) }}</span>
                </p>

            </li>
        @endif
        @if ($chat['sent_from'] == 'CUSTOMER')
            @php
                $messageTime = explode(' ', $chat['message_date']);
            @endphp
            <li class="replies">
                <p>
                    {{ $chat['message'] }}
                    <span>{{ date('h:i A', strtotime($messageTime[1])) }}</span>
                </p>
                @empty(Auth::user()->profile_image)
                    <img src="{{ asset('assets/customer/images/user-small.png') }}" alt="user_image"
                        class="img-fluid" />
                @else
                    <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}"
                        class="img-fluid">
                @endempty
            </li>
        @endif
    @endforeach
</ul>
