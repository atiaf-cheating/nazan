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
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
            <li class="active">@lang('messages.Login')</li>
        </ul>
    </div>
</div>

@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<!-- section -->
<div class="section login">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                    <a href="{{ url('customer/register/') }}">@lang('messages.register')</a><br><br>
                    <form class="form-login" method="POST" action='{{ route("customer.login") }}' aria-label="{{ __('Login') }}">
                        @csrf
                        <img src="img/user.png" alt="" class="img-responsive user" >
                    <h2>@lang('messages.Sign in')</h2>
                    <div class="form-group">
                        <label>@lang('messages.Email'):</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    </div>
                    <div class="form-group">
                        <label>@lang('messages.password'):</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                    <a href="forget.php" class="forget">@lang('messages.forget password') ?</a>
                    <div class="send">
                        <button type="submit" class="btn primary-btn">@lang('messages.login')</button>
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
