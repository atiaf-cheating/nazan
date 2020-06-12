@extends('customer.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Enter Code')</li>
            </ul>
        </div>
    </div>
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif

    <!-- section -->
    <div class="section login password">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form class="form-login" method="POST" action="{{url('customer/update_password')}}">
                        @csrf
                        @method('post')
                        <img src="{{asset('img/password.png')}}" alt="" class="img-responsive user" >
                        <h2>@lang('messages.Enter Code')</h2>
                        <input type="hidden" name="password" value="{{$pass}}">
                        <div class="validation">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-sm-3 form-group">
                                        <input type="text" name="seg1" class="input form-control text-center" placeholder="-">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <input type="text" name="seg2" class="input form-control text-center" placeholder="-">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <input type="text" name="seg3" class="input form-control text-center" placeholder="-">
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <input type="text" name="seg4" class="input form-control text-center" placeholder="-">
                                    </div>
                                </div>
                                @if ($errors->any())
                                    <div class="invalid-feedback text-center">
                                        @lang('messages.code incorrect')!
                                    </div>
                                @endif

                            </div>
                        </div>
                        <button type="submit" class="btn primary-btn">@lang('messages.Send')</button>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->



@endsection
