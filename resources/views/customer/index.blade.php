@extends('customer.layout')
@section('content')
    {{--        @php dd($categories) @endphp--}}

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <!-- NAVIGATION -->
    <div id="navigation">
        <!-- container -->
        <div class="container">
            <a class="toggleMenu" href="#"><i class="fa fa-bars"></i></a>
            <ul class="nav">
                <li><a class="first" href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li><a href="{{url('/customer/aboutus')}}">@lang('messages.about us')</a></li>
                <li>
                    <a href="#">@lang('messages.categories')</a>
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{url('/customer/products/'.$category->id)}}">{{$category->arabic_name}}- {{$category->english_name}}</a>
                                @if($category->subCategories)
                                    <ul>
                                        @foreach($category->subCategories as $subCategory)
                                            <li>
                                                <a href="{{url('/customer/products/'.$subCategory->id)}}">{{$subCategory->arabic_name}}-{{$subCategory->english_name}}</a>
                                                @if($subCategory->subCategories)
                                                    <ul>
                                                        @foreach($subCategory->subCategories as $subCategory)
                                                            <li>
                                                                <a href="{{url('/customer/products/'.$subCategory->id)}}">{{$subCategory->arabic_name}}-{{$subCategory->english_name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                        {{--                    <li>--}}
                        {{--                        <a href="#">department name</a>--}}
                        {{--                        <ul>--}}
                        {{--                            <li><a href="#">product name</a></li>--}}
                        {{--                            <li><a href="#">product name</a></li>--}}
                        {{--                            <li><a href="#">product name</a></li>--}}
                        {{--                        </ul>--}}
                        {{--                    </li>--}}
                    </ul>
                </li>
                <li><a href="{{url('customer/promotions')}}">@lang('messages.offers')</a></li>
                <li><a href="{{url('/customer/policy')}}">@lang('messages.policy')</a></li>
                <li><a href="{{url('/customer/contact_us')}}">@lang('messages.Contact us')</a></li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /NAVIGATION -->

    <!-- HOME -->
    <div id="home">
        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home-wrap">
                <!-- home slick -->
                <div id="home-slick">
                    <!-- banner -->
                    @foreach($gallery as $galleryItem)
                        <div class="banner banner-1">
                            <img src="{{asset('images/galleries/'.$galleryItem->large_image)}}" alt="">
                            <div class="banner-caption">
                                <h1 class="white-color">@lang('messages.New Product Collection')</h1>
                                <a href="{{url('customer/products/'.$products[0]->cat_id)}}" class="btn primary-btn">@lang('messages.Shop Now')</a>
                            </div>
                        </div>
                @endforeach
                <!-- /banner -->
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOME -->

    <!-- section -->
    <div class="section collection">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- banner -->
                {{--                @php dd($products)@endphp--}}

                @foreach($gallery as $galleryItem)
                    <div class="col-md-4 col-sm-6">
                        <a class="banner banner-1" href="{{url('customer/products/'.$products[0]->cat_id)}}">
                            <img src="{{asset('images/galleries/'.$galleryItem->phone_image)}}" alt=""/>
                            <div class="banner-caption text-center">
                                <h2 class="white-color">@lang('messages.new collection')</h2>
                            </div>
                        </a>
                    </div>
            @endforeach
            <!-- /banner -->


            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section side">
        <!-- container -->
        <div class="container">
            <div class="col-md-12">
                <div class="section">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="best-seller">
                                        <!-- section-title -->
                                        <div class="col-md-12">
                                            <div class="section-title">
                                                <h2 class="title">@lang('messages.Best sellers')</h2>
                                                <div class="pull-right">
                                                    <div class="product-slick-dots-1 custom-dots"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /section-title -->
                                        <!-- Product Slick -->
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div id="product-slick-1" class="product-slick">
                                                @foreach($products as $product)
                                                    @if(isset($product->colors[0]) && isset($product->colors[0]->sizes[0]))
{{--                                                        @php dd($product)  @endphp--}}

                                                        @if(in_array($product->id ,$bestSellers->toArray()))
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
                                                                                <form action="{{url('customer/add_to_cart')}}" method="post" class="col" >
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

                                                                <div class="clearfix visible-sm visible-xs"></div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <!-- /Product Single -->

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Product Slick -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="trending">
                                        <!-- section-title -->
                                        <div class="col-md-12">
                                            <div class="section-title">
                                                <h2 class="title">@lang('messages.trending')</h2>
                                                <div class="pull-right">
                                                    <div class="product-slick-dots-2 custom-dots"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /section-title -->

                                        <!-- Product Slick -->
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div id="product-slick-2" class="product-slick">
                                                    <!-- Product Single -->

                                                @for($i=0 ; $i<5 ;$i++)
                                                    @if(isset($products[$i]->colors[0]) && isset($products[$i]->colors[0]->sizes[0]))

                                                        <!-- Product Single -->
                                                            <div class="col-md-4 col-sm-6 col-xs-6 single-product-float">
                                                                <div class="product product-single">
                                                                    <div class="product-thumb">
                                                                        <div class="product-label">
                                                                            <span>@lang('messages.new')</span>
                                                                            <span class="sale">-@if($products[$i]->colors[0]->sizes[0]->discount != null){{$products[$i]->colors[0]->sizes[0]->discount}}@elseif($products[$i]->colors[0]->sizes[0]->discount == null)0 @endif%</span>
                                                                        </div>
                                                                        <a class="main-btn quick-view" href="{{url('/customer/product/details/'.$products[$i]->id)}}"><i class="fa fa-eye"></i> @lang('messages.details')</a>
                                                                        <img src="{{asset('images/products/'.$products[$i]->image_url)}}" alt="">
                                                                    </div>
                                                                    <div class="product-body">
                                                                        <h3 class="product-price">
                                                                            @if($products[$i]->colors[0]->sizes[0]->discount == null) ${{$products[$i]->colors[0]->sizes[0]->price}}
                                                                            @elseif($products[$i]->colors[0]->sizes[0]->discount != null)
                                                                                ${{ $products[$i]->colors[0]->sizes[0]->price - $products[$i]->colors[0]->sizes[0]->price *$products[$i]->colors[0]->sizes[0]->discount /100}}
                                                                            @endif
                                                                            <del class="product-old-price">@if($products[$i]->colors[0]->sizes[0]->discount == null)
                                                                                @elseif($products[$i]->colors[0]->sizes[0]->discount != null)
                                                                                    ${{$products[$i]->colors[0]->sizes[0]->price}}
                                                                                @endif
                                                                            </del>

                                                                        </h3>
                                                                        <h2 class="product-name"><a href="{{url('/customer/product/details/'.$products[$i]->id)}}">{{$products[$i]->arabic_name}} - {{$products[$i]->english_name}} </a></h2>
                                                                        <div class="product-btns row" style="display: flex;">

                                                                        @if($product->is_favourite == false)
                                                                                <a class="main-btn icon-btn" href="{{url('/customer/product/add_to_favourites/'.$products[$i]->id)}}" data-target="#exampleModal"><i class="fa fa-heart-o"></i></a>
                                                                            @elseif($product->is_favourite == true)
                                                                                <a class="main-btn icon-btn" href="{{url('/customer/product/remove_favourites/'.$products[$i]->id)}}" data-target="#exampleModal"><i class="fa fa-heart"></i></a>
                                                                            @endif
                                                                            <form action="{{url('customer/add_to_cart')}}" method="post" class="col">
                                                                                @csrf
                                                                                <input type="hidden" name="product_id" value="{{$products[$i]->id}}">
                                                                                <input type="hidden" name="arabic_name" value="{{$products[$i]->arabic_name}}">
                                                                                <input type="hidden" name="english_name" value="{{$products[$i]->english_name}}">

                                                                                <input type="hidden" name="description" value="{{$products[$i]->description}}">
                                                                                <input type="hidden" name="image_url" value="{{$products[$i]->image_url}}">
                                                                                <input type="hidden" name="cat_id" value="{{$products[$i]->cat_id}}">
                                                                                <input type="hidden" name="merchant_id" value="{{$products[$i]->merchant_id}}">
                                                                                <input type="hidden" name="brand_id" value="{{$products[$i]->brand_id}}">

                                                                                <input type="hidden" name="color_id" value="{{$products[$i]->colors[0]->id}}">
                                                                                <input type="hidden" name="size_id" value="{{$products[$i]->colors[0]->sizes[0]->id}}">
                                                                                <input type="hidden" name="price" value="{{$products[$i]->colors[0]->sizes[0]->price}}">
                                                                                <input type="hidden" name="discount" value="{{$products[$i]->colors[0]->sizes[0]->discount}}">

                                                                                <button type="submit"  class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> @lang('messages.Add to Cart')</button>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="clearfix visible-sm visible-xs"></div>
                                                    @endif
                                                @endfor
                                                <!-- /Product Single -->

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Product Slick -->
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="information">
                                        <!-- section-title -->
                                        <div class="col-md-12">
                                            <div class="section-title">
                                                <h2 class="title">@lang('messages.Insider Information')</h2>
                                            </div>
                                        </div>
                                        <!-- /section-title -->

                                        <!-- Product Slick -->
                                        <div class="col-md-12">
                                            <div class="row">

                                                @foreach($articles as $article)
                                                    <div class="info-det">
                                                        <div class="col-md-4">
                                                            <img src="{{asset('images/articles/'.$article->image_url)}}" alt="" class="img-responsive" >
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h3>{{$article->title}}</h3>
                                                            <p>
                                                                {{$article->body}}
                                                            </p>
                                                            <a href="{{url('customer/blog_details/'.$article->id)}}" class="more">@lang('messages.Read More')</a>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <div class="row">
                                <div class="banner banner-2">
                                    <img src="{{asset('img/banner15.jpg')}}" alt="" class="img-responsive">
                                    <div class="banner-caption">
                                        <h2 class="white-color">@lang('messages.new collection')<br></h2>
                                        <a href="{{url('customer/products/'.$products[0]->cat_id)}}" class="btn primary-btn">@lang('messages.Shop Now')</a>

                                    </div>
                                </div>
                                <div class="banner banner-2">
                                    <img src="{{asset('img/banner15.jpg')}}" alt="" class="img-responsive">
                                    <div class="banner-caption">
                                        <h2 class="white-color">@lang('messages.new collection')<br></h2>
                                        <a href="{{url('customer/products/'.$products[0]->cat_id)}}" class="btn primary-btn">@lang('messages.Shop Now')</a>
                                    </div>
                                </div>
                                <div class="banner banner-2">
                                    <img src="{{asset('img/banner15.jpg')}}" alt="" class="img-responsive">
                                    <div class="banner-caption">
                                        <h2 class="white-color">@lang('messages.new collection')<br></h2>
                                        <a href="{{url('customer/products/'.$products[0]->cat_id)}}" class="btn primary-btn">@lang('messages.Shop Now')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="customers">
                        <!-- section-title -->
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="title">@lang('messages.What our customers are saying')</h2>
                                <div class="pull-right">
                                    <div class="product-slick-dots-3 custom-dots"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /section-title -->

                        <!-- Product Slick -->
                        <div class="col-md-12">
                            <div class="row">
                                <div id="product-slick-3" class="product-slick">
                                    <!-- Product Single -->
                                    @foreach($products as $product)
                                        @if(isset($product->colors[0]) && isset($product->colors[0]->sizes[0]))
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
                                                    <div class="rate">
                                                        <div class="product-rating">
                                                            @for($i = 0 ; $i < $product->total_reviews ; $i++)
                                                                <i class="fa fa-star"></i>
                                                            @endfor
                                                            @for($i = 0 ; $i < 5- $product->total_reviews ; $i++)
                                                                <i class="fa fa-star-o empty"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    @if(count($product->reviews) >0)
                                                        <p class="reviewQuote">{{$product->reviews[0]->comment}}</p>
                                                    @endif
                                                    <div class="product-btns row" style="display: flex;">
                                                        @if($product->is_favourite == false)
                                                            <a class="main-btn icon-btn col" href="{{url('/customer/product/add_to_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart-o"></i></a>
                                                        @elseif($product->is_favourite == true)
                                                            <a class="main-btn icon-btn col" href="{{url('/customer/product/remove_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart"></i></a>
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
                                        @endif
                                    @endforeach
                                <!-- /Product Single -->

                                </div>
                            </div>
                        </div>
                        <!-- /Product Slick -->
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="sponsers">
                        <!-- section-title -->
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2 class="title">@lang('messages.Brands')</h2>
                                <div class="pull-right">
                                    <div class="product-slick-dots-4 custom-dots"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /section-title -->

                        <!-- Product Slick -->
                        <div class="col-md-12">
                            <div class="row">
                                <div id="product-slick-4" class="product-slick">
                                @foreach($products as $product)
                                    <!-- Product Single -->
                                        <div class="sponsers-single">
                                            <img src="{{asset('images/brands/'.$product->brand->image_url)}}" alt="" >
                                        </div>
                                        <!-- /Product Single -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /Product Slick -->
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->


@endsection
