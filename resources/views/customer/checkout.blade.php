@extends('customer.layout')
@section('content')
    @php
        if(session()->has('cart')){
           $cart = session()->get('cart');
       }
    @endphp

    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li><a href="{{url('customer/cart_details')}}">MY Cart</a></li>
                <li class="active">@lang('messages.Check Out')</li>
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
    <div class="section checkout">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <form id="checkout-form" class="clearfix" method="post" action="{{url('customer/order/create')}}">
                    @csrf
                    <div class="col-md-6">
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">@lang('messages.Billing Details')</h3>
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Shipping'):</label>
                                <select name="city" class="input form-control">
                                   @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->arabic_name}}-{{$city->english_name}}</option>
                                   @endforeach
                                </select>
                                <span><b>@lang('messages.shipping fees'): </b> 50 $</span>
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Enter PromoCode'):</label>
                                <input name="promo_code" class="input form-control">
{{--                                <div class="valid-feedback">--}}
{{--                                    PromoCode correct!--}}
{{--                                </div>--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    PromoCode uncorrect!--}}
{{--                                </div>--}}
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Address'):</label>
                                <input name="address" class="input" type="text">
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Street'):</label>
                                <input name="street" class="input" type="text">
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Building No'):</label>
                                <input name="building" class="input" type="text">
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.floor No'):</label>
                                <input name="floor" class="input" type="text">
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.flat No'):</label>
                                <input name="flat" class="input" type="text">
                            </div>
                            <div class="form-group">
                                <label>@lang('messages.Special Sign'):</label>
                                <input name="special_sign" class="input" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payments-methods">
                            <div class="section-title">
                                <h3 class="title">@lang('messages.Payments Methods')</h3>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payments" id="payments-1" checked>
                                <label for="payments-1">@lang('messages.Direct Bank Transfer')</label>
                                <div class="caption">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    <p>
                                </div>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payments" id="payments-2">
                                <label for="payments-2">@lang('messages.Cheque Payment')</label>
                                <div class="caption">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    <p>
                                </div>
                            </div>
                            <div class="input-checkbox">
                                <input type="radio" name="payments" id="payments-3">
                                <label for="payments-3">@lang('messages.Paypal System')</label>
                                <div class="caption">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    <p>
                                </div>
                            </div>
                        </div>

                        <div class="payments-methods">
                            <div class="section-title">
                                <h3 class="title">@lang('messages.TOTAL')</h3>
                            </div>
                            <div class="total-details">
                                <span class="strong">@lang('messages.Total Cost'):</span><span>
                                    {{$cart->totalPrice}} $
                                </span>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn primary-btn">@lang('messages.Done')!</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

@endsection
