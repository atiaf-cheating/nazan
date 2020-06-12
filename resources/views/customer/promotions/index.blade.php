@extends('customer.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.offers')</li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside widget -->
                    <div class="aside">
                        <h3 class="aside-title">@lang('messages.Filter by Brand')</h3>
                        <ul class="list-links">
                            @foreach($promotions as $promotion)
                                @if(isset($promotion->colors[0]) && isset($promotion->colors[0]->sizes[0]))

                                    @if($language == 'en')
                                        <li><a href="{{url('customer/promotions/'.$promotion->brand->id)}}">{{$promotion->brand->english_name}}</a></li>
                                    @elseif($language == 'ar')
                                        <li><a href="{{url('customer/promotions/'.$promotion->brand->id)}}">{{$promotion->brand->arabic_name}}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!-- /aside widget -->
                    <div class="banner banner-2">
                        <a href="#"><img src="{{asset('img/banner15.jpg')}}" alt="" class="img-responsive"></a>
                    </div>
                    <!-- /aside widget -->
                </div>
                <!-- /ASIDE -->

                <!-- MAIN -->
                <div id="main" class="col-md-9">
                    <!-- STORE -->
                    <div id="store">
                        <div class="section-title">
                            <h3 class="title">@lang('messages.offers')</h3>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Product Single -->
                        @foreach($promotions as $product)
                            {{--                            @php dd($product->colors[0]->sizes[0]->discount) @endphp--}}
                            @if(isset($product->colors[0]) && isset($product->colors[0]->sizes[0]))
                                <!-- Product Single -->

                                        <div class="col-md-4 col-sm-6 col-xs-6 single-product-float">
                                            <div class="product product-single">
                                                <div class="product-thumb">
                                                    <div class="product-label">
                                                        <span>@lang('messages.new')</span>
                                                        <span class="sale">-@if($product->colors[0]->sizes[0]->discount != null){{$product->colors[0]->sizes[0]->discount}}@elseif($product->colors[0]->sizes[0]->discount == null)0 @endif%</span>
                                                    </div>
                                                    <a class="main-btn quick-view" href="{{url('/customer/product/details/'.$product->id)}}"><i class="fa fa-eye"></i> @lang('messages.details')</a>
                                                    <img src="{{asset('images/products/'.$product->image_url)}}" alt="">
                                                </div>
                                                <div class="product-body">
                                                    {{--                                            @php dd($price_from) @endphp--}}
                                                    <h3 class="product-price">
                                                        @if($product->colors[0]->sizes[0]->discount == null) ${{$product->colors[0]->sizes[0]->price}}
                                                        @elseif($product->colors[0]->sizes[0]->discount != null)
                                                            ${{ $product->colors[0]->sizes[0]->price - $product->colors[0]->sizes[0]->price *$product->colors[0]->sizes[0]->discount /100}}
                                                        @endif
                                                        <del class="product-old-price">@if($product->colors[0]->sizes[0]->discount == null)
                                                            @elseif($product->colors[0]->sizes[0]->discount != null)
                                                                ${{$product->colors[0]->sizes[0]->price}}
                                                            @endif
                                                        </del>
                                                    </h3>
                                                    <h2 class="product-name"><a href="{{url('/customer/product/details/'.$product->id)}}">{{$product->arabic_name}} - {{$product->english_name}} </a></h2>
                                                    <div class="product-btns row" style="display:flex;">
                                                        @if($product->is_favourite == false)
                                                        <a class="main-btn icon-btn" href="{{url('/customer/product/add_to_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart-o"></i></a>
                                                    @elseif($product->is_favourite == true)
                                                        <a class="main-btn icon-btn" href="{{url('/customer/product/remove_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart"></i></a>
                                                    @endif
                                                    <form action="{{url('customer/add_to_cart')}}" method="post" class="col">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    <input type="hidden" name="arabic_name" value="{{$product->arabic_name}}">
                                                    <input type="hidden" name="english_name" value="{{$product->english_name}}">
                                                    <input type="hidden" name="description" value="{{$product->description}}">
                                                    <input type="hidden" name="image_url" value="{{$product->image_url}}">
                                                    <input type="hidden" name="cat_id" value="{{$product->cat_id}}">
                                                    <input type="hidden" name="merchant_id" value="{{$product->merchant_id}}">
                                                    <input type="hidden" name="brand_id" value="{{$product->brand_id}}">
                                                    <input type="hidden" name="color_id" value="{{$product->colors[0]->id}}">
                                                    <input type="hidden" name="size_id" value="{{$product->colors[0]->sizes[0]->id}}">
                                                    <input type="hidden" name="price" value="{{$product->colors[0]->sizes[0]->price}}">
                                                    <input type="hidden" name="discount" value="{{$product->colors[0]->sizes[0]->discount}}">
                                                    <button type="submit"  class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> @lang('messages.Add to Cart')</button>

                                                </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <!-- /Product Single -->
                                    <div class="clearfix visible-sm visible-xs"></div>
                            @endif
                        @endforeach
                            <!-- /Product Single -->



                            <div class="clearfix visible-sm visible-xs"></div>
                            <ul class="reviews-pages">
                                <li class="active">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#"><i class="fa fa-caret-right"></i></a></li>
                            </ul>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /STORE -->
                </div>
                <!-- /MAIN -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

@endsection
