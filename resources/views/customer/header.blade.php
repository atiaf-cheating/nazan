

<!DOCTYPE html>
<html lang="en">
    @php
        $language = App::getLocale();
    @endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@lang('messages.NAZAN | Home')</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("img/favicon.png") }}"/>
    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}"/>

    <!-- Font Awesome Icon -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet"  href="{{ asset('css/font-awesome.min.css') }}"/>

    <!-- Custom stlylesheet -->
    @if($language == 'en')
        <link type="text/css" rel="stylesheet"href="{{ asset('css/style.css') }}" />
    @else
        <link type="text/css" rel="stylesheet"href="{{ asset('css/style-ar.css') }}" />
    @endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!-- HEADER -->
<header>

    <div id="top-header">
        <div class="container">
            <div class="pull-left">
                <span>@lang('messages.free shipping on all domestic orders above 45.00 omr')</span>
            </div>
            <div class="pull-right">
                <ul class="header-top-links">
                    {{--                    <li><a href="#">عربى<i class="fa fa-globe"></i></a></li>--}}
                    <li class="nav-item dropdown" style="list-style: none;">
                        @if($language == 'ar')
                            <a class="dropdown-item" href="{{ route('/en',['lang'=>'en']) }}">
                                @lang('messages.english')
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ route('/ar',['lang'=>'ar']) }}">
                                @lang('messages.arabic')
                            </a>
                        @endif
                        {{--                        <a id="navbarDropdown" style="@if($language == 'ar')float: left;@else float: right;@endif" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
                        {{--                            @lang('messages.language') <span class="caret"></span>--}}
                        {{--                        </a>--}}

                        {{--                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
                        {{--                            <a class="dropdown-item" href="{{ route('/ar',['lang'=>'ar']) }}">--}}
                        {{--                                @lang('messages.arabic')--}}
                        {{--                            </a>--}}
                        {{--                            <a class="dropdown-item" href="{{ route('/en',['lang'=>'en']) }}">--}}
                        {{--                                @lang('messages.english')--}}
                        {{--                            </a>--}}

                        {{--                        </div>--}}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="{{url('/customer/home')}}">
                        <img src="{{asset('img/logo.png')}}" alt="">
                    </a>
                </div>
            </div>
            <div class="pull-right">
                <ul class="header-btns">
                    <!-- Account -->
                    <li class="header-account dropdown default-dropdown">
                        <div>
                            <div class="header-btns-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <a href="{{url('customer/profile')}}"><strong class="text-uppercase">@lang('messages.My Account')</strong></a>
                        </div>
                        @if(!session()->has('customer'))
                            <a href="{{url('customer/register')}}" class="">@lang('messages.register')</a>
                            <span class="white">/</span>
                            <a href="{{url('login/customer')}}" class="">@lang('messages.Sign in')</a>
                        @else
{{--                            <a href="{{url('logout/customer')}}" class="">@lang('messages.Logout')</a>--}}
                            <a href="{{url('logout/customer')}}" class="">Logout</a>
                        @endif
                    </li>
                    <!-- /Account -->

                    <!-- Cart -->
                    @php
                        if(session()->has('cart')){
                            $cart = session()->get('cart');
                        }
                    @endphp
                    <li class="header-cart dropdown default-dropdown" >
                        <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="qty">
                                    @if(isset($cart))
                                        {{count($cart->products)}}
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                            <strong class="text-uppercase">@lang('messages.My cart'):</strong>
                            <br>
                            <span>
                                 @if(isset($cart) && isset($cart->totalPrice))
                                    ${{$cart->totalPrice}}
                                @endif
                            </span>
                        </a>
                        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                            @if(isset($cart))
                                @foreach($cart->products as $product)

                                    <div class="product product-widget">
                                        <div class="product-thumb">
                                            <img src="{{asset('images/products/'.$product['image_url'])}}" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-price">$@if($product['discount'] == null) {{$product['price']}} @else {{$product['price'] - $product['price']*$product['discount']/100}} @endif <span class="qty">x @if(array_key_exists('quantity',$product)) {{$product['quantity']}} @else 1 @endif</span></h3>
                                            <h2 class="product-name"><a href="{{url('customer/product/details/'.$product['id'])}}">{{$product['english_name']}} - {{$product['arabic_name']}}</a></h2>
                                        </div>
                                        <form method="post" action="{{url('customer/remove_from_cart')}}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product['id']}}">
                                            <button type="submit" class="cancel-btn"><i class="fa fa-close"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                            @endif
                            <a href="{{url('customer/cart_details')}}" class="main-btn">@lang('messages.View Cart')</a>
                                @if(isset($cart) && count($cart->products)> 0)
                                    <a href="{{url('customer/checkout')}}" class="btn primary-btn">@lang('messages.Check Out')<i class="fa fa-arrow-circle-right"></i></a>
                                @else
                                    <a href="#" class="btn primary-btn" disabled="true">@lang('messages.Check Out')<i class="fa fa-arrow-circle-right"></i></a>
                                @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<!-- /HEADER -->
