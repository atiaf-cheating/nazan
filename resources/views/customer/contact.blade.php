@extends('customer.layout')
@section('content')
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
            <li class="active">@lang('messages.Contact us')</li>
        </ul>
    </div>
</div>
@php
    $language = App::getLocale();
@endphp
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
{{--@php  dd($info) @endphp--}}
<!-- section -->
<div class="section contactus">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="section-title">
                    <h3 class="title">@lang('messages.Contact Details')</h3>
                </div>
                <ul class="list-links keep">
                    <li><i class="fa fa-home"></i> </li>
                    <li><i class="fa fa-phone"></i>{{$info->phone}}</li>
                    <li><i class="fab fa-whatsapp"></i>{{$info->phone}}</li>
                    <li><i class="fa fa-envelope"></i> </li>
                </ul>
                <div class="section-title">
                    <h3 class="title">@lang('messages.Social media pages')</h3>
                </div>
                <ul class="keep social-conatct">
                    <li><a href="{{$info->facebook_url}}"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="{{$info->twitter_url}}"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="{{$info->instagram_url}}"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>

            <div class="col-md-6 col-sm-12">
                <form id="checkout-form" method="post" action="{{url('customer/suggestions')}}" class="clearfix">
                    @csrf
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">@lang('messages.Send a message')</h3>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.Your Name'):</label>
                            <input class="input form-control" name="name" type="text">
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.Your E-mail'):</label>
                            <input class="input form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.Message type'):</label>
                            <select class="input form-control" name="category">
                                <option>@lang('messages.Inquiry')</option>
                                <option>@lang('messages.Complaint')</option>
                                <option>@lang('messages.Suggestion')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('messages.Your Message'):</label>
                            <textarea class="input form-control" rows="5" name="message" cols="30"></textarea>
                        </div>
                        <button type="submit" class="btn primary-btn">@lang('messages.Send')</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3455.5692830713465!2d31.431528000000004!3d29.991806!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1519638265059" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->

@endsection
