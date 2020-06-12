@extends('customer.layout')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger" style="width: 90%;margin-left: 2%;">
            <ul class=" ">
                @foreach ($errors->all() as $error)
                    <li class="">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{--@php dd('ffff') @endphp--}}
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Register')</li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section login">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form class="form-login" method="POST" action='{{ url("register/customer") }}' aria-label="{{ __('register') }}">
                        @csrf
                        <img src="{{asset('img/user.png')}}" alt="" class="img-responsive user" >
                        <h2>@lang('messages.Register')</h2>
                        <div class="form-group">
                            <label>@lang('messages.Name'):</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        </div>
                        <div class="form-group">
                            <label>@lang('messages.Email'):</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >

                        </div>
                        <div class="form-group">
                            <label>@lang('messages.password'):</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.confirm password'):</label>
                            <input id="c_password" type="password" class="form-control @error('c_password') is-invalid @enderror" name="c_password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.phone'):</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" >

                        </div>
                        <div class="send">
                            <button type="submit" class="btn primary-btn">@lang('messages.Register')</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->




    </div>
@endsection
