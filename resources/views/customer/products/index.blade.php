@extends('customer.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Products department')</li>
            </ul>
        </div>
    </div>

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
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
                        <h3 class="aside-title">@lang('messages.Filter by Price')</h3>
                        <div class="col-md-12">
                            <div class="row">
                                <form action="{{url('/customer/products/'.$parent_cat.'/price_filter')}}" method="post">
                                    @csrf
                                    <span>@lang('messages.from')</span>
                                    <input type="number" value="{{$price_from}}" name="price_from" class="valueStart input" min="0" max="9598" value="0">
                                    <input type="hidden" value="{{$parent_cat}}" name="parent_cat">
                                    <span>@lang('messages.to')</span>
                                    <input type="number" value="{{$price_to}}" name="price_to"  class="valueStart input" min="0" max="9598" value="626"><br><br><br>
                                    <button type="submit" class="primary-btn add-to-cart">@lang('messages.Apply')</button>
                                </form>
                            </div>
                        </div>
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
                            <h3 class="title">@lang('messages.Products department')</h3>
                        </div>
                        <!-- row -->
                        <div class="row" style="overflow: auto;">
                            @foreach($products as $product)
                            {{--                            @php dd($product->colors[0]->sizes[0]->discount) @endphp--}}
                                @if(isset($product->colors[0]) && isset($product->colors[0]->sizes[0]))
                                <!-- Product Single -->
                                    @if($price_from != null && $product->colors[0]->sizes[0]->price >= $price_from && $product->colors[0]->sizes[0]->price <= $price_to)
                                        <div class="col-md-4 col-sm-6 col-xs-6 single-product-float" >
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
                                                        <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
                                                        <form action="{{url('customer/add_to_cart')}}" method="post" >
                                                            @csrf
                                                            <input type="hidden" name="parent_cat" value="{{$parent_cat}}">
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
                                    @elseif($price_from == null)
                                        <div class="col-md-4 col-sm-6 col-xs-6 single-product-float" >
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
                                                        @if($product->colors[0]->sizes[0]->discount == null)
                                                            ${{$product->colors[0]->sizes[0]->price}}
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
                                                        <form action="{{url('customer/add_to_cart')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{$product->id}}">
{{--                                                            <input type="hidden" name="price_from" value="{{$product->id}}">--}}
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
                                    @endif
                                <!-- /Product Single -->
                                    <div class="clearfix visible-sm visible-xs"></div>
                                @endif
                            @endforeach

                            <div class="clearfix visible-sm visible-xs"></div>
{{--                            <ul class="reviews-pages">--}}
{{--                                <li class="active">1</li>--}}
{{--                                <li><a href="#">2</a></li>--}}
{{--                                <li><a href="#">3</a></li>--}}
{{--                                <li><a href="#"><i class="fa fa-caret-right"></i></a></li>--}}
{{--                            </ul>--}}
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
    {{ $products->links() }}

@endsection
