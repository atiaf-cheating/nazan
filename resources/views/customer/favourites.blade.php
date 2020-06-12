@extends('customer.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Favorite Items')</li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section login profile favourite">
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
                                <h2 class="title">@lang('messages.Favorite Items')</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        @foreach($products as $product)
{{--                            @php dd($product->colors[0]) @endphp--}}
                            <div class="cart-header">
                                <div class="close1">
                                    <a class="main-btn icon-btn" href="{{url('/customer/product/remove_favourites/'.$product->id)}}"><i class="fa fa-close"></i></a>
                                </div>
                                <div class="cart-sec simpleCart_shelfItem">
                                    <div class="cart-item cyc">
                                        <img src="{{asset('images/products/'.$product->image_url)}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="cart-item-info">
                                        <h3><a href="{{url('customer/product/details/'.$product->id)}}">{{$product->arabic_name}}-{{$product->english_name}}</a></h3>
{{--                                        <p class="price2"><del>$97.50</del>$80.50</p>--}}
                                        <p class="product-price">
                                            @if($product->colors[0]->sizes[0]->discount == null)
                                                ${{$product->colors[0]->sizes[0]->price}}
                                            @elseif($product->colors[0]->sizes[0]->discount != null)
                                                ${{ $product->colors[0]->sizes[0]->price - $product->colors[0]->sizes[0]->price *$product->colors[0]->sizes[0]->discount /100}}
                                            @endif
                                            <del class="product-old-price">
                                                @if($product->colors[0]->sizes[0]->discount == null)
                                                @elseif($product->colors[0]->sizes[0]->discount != null)
                                                    ${{$product->colors[0]->sizes[0]->price}}
                                                @endif
                                            </del>
                                        </p>
                                        <form action="{{url('customer/add_to_cart')}}" method="post" >
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="arabic_name" value="{{$product->arabic_name}}">
                                            <input type="hidden" name="english_name" value="{{$product->english_name}}">
                                            <input type="hidden" name="description" value="{{$product->description}}">
                                            <input type="hidden" name="image_url" value="{{$product->image_url}}">
                                            <input type="hidden" name="cat_id" value="{{$product->cat_id}}">
                                            <input type="hidden" name="merchant_id" value="{{$product->merchant_id}}">
                                            <input type="hidden" name="brand_id" value="{{$product->brand_id}}">
{{--                                            <input type="hidden" name="color_id" value="{{$product->colors[0]->id}}">--}}
{{--                                            <input type="hidden" name="size_id" value="{{$product->colors[0]->sizes[0]->id}}">--}}
{{--                                            <input type="hidden" name="price" value="{{$product->colors[0]->sizes[0]->price}}">--}}
{{--                                            <input type="hidden" name="discount" value="{{$product->colors[0]->sizes[0]->discount}}">--}}
                                            <button type="submit"  class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> @lang('messages.Add to Cart')</button>

                                        </form>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->


@endsection
