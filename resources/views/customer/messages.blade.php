@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

@if(Session::has('error'))
 <div class="alert alert-danger">
   {{ Session::get('error')}}
 </div>
 @endif

 @error('payment_method')
    <div class="alert alert-danger">
        {{$message}}
    </div>
 @enderror