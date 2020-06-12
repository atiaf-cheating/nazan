@extends('customer.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Change Password')</li>
            </ul>
        </div>
    </div>

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger @if($language == 'ar') rtl @endif" style="width: 90%;margin-left: 2%;">
            <ul class=" @if($language == 'ar') rtl @endif">
                @foreach ($errors->all() as $error)
                    <li class=" @if($language == 'ar') rtl @endif">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- section -->
    <div class="section login change">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form class="form-login" action="{{url('customer/update_password')}}" method="post">
                        @csrf
                        <img src="{{asset('img/change1.png')}}" alt="" class="img-responsive user" >
                        <h2>@lang('messages.Change Password')</h2>
                        <div class="validation">
                            <div class="form-group">
                                <label>@lang('messages.New password'):</label>
                                <input name="password" class="input form-control" type="password" />
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Repeat new password'):</label>
                                <input name="c_password" class="input form-control" type="password" />
                            </div>
                        </div>
                        <button type="submit" class="btn primary-btn">@lang('messages.Change')</button>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

@endsection
