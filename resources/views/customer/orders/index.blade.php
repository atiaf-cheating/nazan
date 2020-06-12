@extends('customer.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.orders')</li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section login profile favourite previous">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <img src="img/user.png" alt="" class="img-responsive user">
                    <a href="{{url('customer/profile')}}" class="btn btn-profile bg">@lang('messages.My info')</a>
                    <a href="{{url('customer/change_password')}}" class="btn btn-profile bg">@lang('messages.Change Password')</a>
                    <a href="{{url('customer/favourites')}}" class="btn btn-profile bg">@lang('messages.Favorite Items')</a>
                    <!-- <a href="prev-orders.php" class="btn btn-profile bg">My Prev Orders</a> -->
                    <a href="{{url('customer/orders')}}" class="btn btn-profile bg">@lang('messages.My Orders')</a>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title">
                                <h2 class="title">@lang('messages.orders')</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="order-block">
                            @foreach($orders as $order)
                                <div class="order checkout-cart">

                                    <div class="order-info">
                                        <h5>@lang('messages.Order Date'): <span class="color">{{$order->created_at}}</span></h5>
                                        <h5>@lang('messages.Order No'): <span class="color">{{$order->id}}</span></h5>
                                    </div>

                                    <div class="steps">
                                        <span class="righton active">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <p>المراجعة</p>
                                        </span>

                                        <span class="righton">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <p>التجهيز</p>
                                        </span>

                                        <span class="righton">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <p>التوصيل</p>
                                        </span>

                                        <span class="righton">
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            <p>التسليم</p>
                                        </span>

                                    </div>

                                    <ul class="product-list">
                                        @foreach($order->orderProducts as $product)
                                            <li>
                                                <div class="left">
                                                    <img src="{{asset('images/products/'.$product->product_image_url)}}" class="img-responsive" alt="">
                                                </div>
                                                <div class="right">
                                                    <h5>{{$product->product_arabic_name}} - {{$product->product_english_name}}</h5>
                                                    <!-- <p>200 LE</p> -->
                                                    <p><span class="color">@lang('messages.quantity'): </span>{{$product->quantity}}</p>
                                                    <p><span class="color">@lang('messages.price') : </span>{{$product->product_price}} $</p>
                                                    <div class="point">
                                                        <span>{{$product->product_size_arabic_name}} - {{$product->product_size_english_name}}</span>
                                                        <span>{{$product->product_color_arabic_name}}-{{$product->product_color_english_name}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <a href="{{url('customer/order/details/'.$order->id)}}" class="forget color text-center">@lang('messages.View More Details')</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->


@endsection
