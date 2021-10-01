@extends('admin.layouts.app_login')

@section('content')
<div class="login-backgroung">
    <div class="container">
        <div class="wd-dr-inner-login">
            <div class="jumbotron">
                <div class="row wd-dr-inner-future">
                    <div class="col-sm-5">
                        <!--<img src="images/Login-full.png" class="img-responsive">-->
                        <!-- <picture>
                            <source 
                            media="(min-width: 650px)"
                            srcset="images/Login-full.png">
                            <source 
                            media="(min-width: 465px)"
                            srcset="images/img2.png"> -->
                            <img src="{{asset('assets/admin/images/Login-full-square.png')}}" 
                            alt="a cute kitten" class="img-login">
                        <!-- </picture> -->
                    </div>
                    <div class="col-sm-7  text-margin">
                        <h1>WELCOME</h1>
                        <h2>Let’s get Started</h2>
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error')}}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success')}}
                            </div>
                        @endif
                        <form role="form " action="{{route('admin.auth.login')}}" method="post" class="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="name"></label>
                                <input type="email" class="form-control" id="name" name="email" placeholder="Email" required>
                                <!--placing icon using a span element-->
                                <span class="icon fa fa-user fa-lg"></span>
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
    
                            <div class="form-group">
                                <label for="email"></label>
                                <input type="password" class="form-control" id="" name="password" placeholder="Password" required>
                                <span class="icon fa fa-lock fa-lg"></span>
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
    
                            <div class="form-group">
                                <label for="email"></label>
                                <a href="{{route('admin.auth.forgot-password')}}">Forgot Password?</a>
                            </div>
    
                            <div class="form-group">
                                <label for="email"></label>
                                <button class="btn btn-block" type="submit">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection