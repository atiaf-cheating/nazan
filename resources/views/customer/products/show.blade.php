@extends('customer.layout')
@section('content')
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
            <li><a href="{{url('customer/products')}}">@lang('messages.Products department')</a></li>
            <li class="active">{{$product->arabic_name}}- {{$product->english_name}}</li>
        </ul>
    </div>
</div>
@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
{{--        @php dd($product)@endphp--}}

        <!--  Product Details -->
            <div class="product product-details clearfix">
                <div class="col-md-6">
                    <div id="product-main-view">
                        @foreach($product->images as $image)

                            <div class="product-view">
                            <img src="{{asset('images/products/'.$image)}}" alt="">
                        </div>
                        @endforeach

                    </div>
                    <div id="product-view">
                        @foreach($product->images as $image)
                            <div class="product-view">
                                <img src="{{asset('images/products/'.$image)}}" alt="">
                            </div>
                        @endforeach

                    </div>
{{--                </div>                        @php dd($product->colors[0]->sizes)@endphp--}}
                </div>
                <div class="col-md-6">
                    <div class="product-body">
                        <div class="product-label">
                            <span>@lang('messages.new')</span>
                            <span class="sale">-@if($product->colors[0]->sizes[0]->discount == null) 0 @elseif($product->colors[0]->sizes[0]->discount != null) {{$product->colors[0]->sizes[0]->discount}} @endif %</span>
                        </div>
                        <h2 class="product-name">{{$product->arabic_name}}- {{$product->english_name}}</h2>
                        <h3 class="product-price"> @if($product->colors[0]->sizes[0]->discount == null) ${{$product->colors[0]->sizes[0]->price}} @elseif($product->colors[0]->sizes[0]->discount != null)${{ $product->colors[0]->sizes[0]->price - $product->colors[0]->sizes[0]->price *$product->colors[0]->sizes[0]->discount /100}}@endif
                            <del class="product-old-price">@if($product->colors[0]->sizes[0]->discount == null) @elseif($product->colors[0]->sizes[0]->discount != null) ${{$product->colors[0]->sizes[0]->price}} @endif</del>
                        </h3>
                        <div>
                            <div class="product-rating">
{{--                                @php dd($product->total_reviews)@endphp--}}

                            @for($i = 0 ; $i < $product->total_reviews ; $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                            @for($i = 0 ; $i < 5- $product->total_reviews ; $i++)
                                 <i class="fa fa-star-o empty"></i>
                            @endfor

                            </div>
                        </div>
                        <p><strong>@lang('messages.Available quantity'):</strong> {{$product->colors[0]->sizes[0]->quantity}}</p>
                        <hr>

                        <div class="fw-size-choose">
                            <p>@lang('messages.color')</p>
                            @foreach($product->colors as $color)
                                <div class="sc-item">

                                    <input type="radio" onclick="changeSize({{$color->id}})" name="color_id" id="{{$color->english_name}}"
{{--                                           @if($product->colors[0]->id == $color->id) checked @else @endif --}}
                                    >
                                    <label for="{{$color->english_name}}">{{$color->arabic_name}}- {{$color->english_name}}</label>
                                </div>
                                <div class="sizes-div-{{$color->id}}" style="display: none;">
                                    @foreach($color->sizes as $size)
                                        <div class="sc-item" style="">
                                            <input class="single-size" type="radio" name="size_id"  id="{{$size->sizes->english_name}}-size"
{{--                                                   @if($size->sizes->id == $size->size_id) checked @else  @endif--}}
                                            >
                                            <label class="size-label" onclick="hilight(this,{{$size->sizes->id}})" for="{{$size->sizes->english_name}}-size">{{$size->sizes->arabic_name}}- {{$size->sizes->english_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="fw-size-choose-size fw-size-choose">
                            <p>@lang('messages.size')</p>
                                <div class="sc-size"></div>
                        </div>
                        </div>
                        <hr>
                        <div class="product-btns row" style="display:flex;">
                            <div class=" col-md-1 col-lg-1 qty-input" style="padding-top: 2%;">
                                <span class="text-uppercase">@lang('messages.QTY'): </span>
                            </div>
                            <form action="{{url('customer/add_to_cart')}}" method="post" class=" col-md-4 col-lg-4" style="display: contents;">

                                <div class=" col-md-2 col-lg-2 qty-input">
                                    <input class="input" type="number" name="quantity" step="1" min="0" max="" value="1">
                                </div>
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <input type="hidden" name="arabic_name" value="{{$product->arabic_name}}">
                                <input type="hidden" name="english_name" value="{{$product->english_name}}">
                                <input type="hidden" name="description" value="{{$product->description}}">
                                <input type="hidden" name="image_url" value="{{$product->image_url}}">
                                <input type="hidden" name="cat_id" value="{{$product->cat_id}}">
                                <input type="hidden" name="merchant_id" value="{{$product->merchant_id}}">
                                <input type="hidden" name="brand_id" value="{{$product->brand_id}}">
                                <input class="hidden-color" type="hidden" name="color_id" value="{{$product->colors[0]->id}}">
                                <input class="hidden-size" type="hidden" name="size_id" value="{{$product->colors[0]->sizes[0]->id}}">
                                <input type="hidden" name="price" value="{{$product->colors[0]->sizes[0]->price}}">
                                <input type="hidden" name="discount" value="{{$product->colors[0]->sizes[0]->discount}}">
                                <button type="submit"  class="primary-btn add-to-cart cart-button-spaced" ><i class="fa fa-shopping-cart"></i> @lang('messages.Add to Cart')</button>
                            </form>
                            <div class="pull-right  col-md-4  col-lg-4"></div>
                            <div class="pull-right  col-md-1  col-lg-1">
                                @if($product->is_favourite == false)
                                    <a class="main-btn icon-btn" href="{{url('/customer/product/add_to_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart-o"></i></a>
                                @elseif($product->is_favourite == true)
                                    <a class="main-btn icon-btn" href="{{url('/customer/product/remove_favourites/'.$product->id)}}" data-target="#exampleModal"><i class="fa fa-heart"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="product-options">
                            <p><strong>@lang('messages.Share this product'):</strong></p>
                            <ul>
                                <li><a href="#add-to-cart" class="primary-btn add-to-cart" id=add-to-cart"><i class="fa fa-share-alt"></i></a></li>
                                <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.facebook.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://www.facebook.com/"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="https://www.facebook.com/"><i class="fa fa-pinterest-p"></i></a></li>
                                <li><a href="https://www.facebook.com/"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                        <hr>
                        <div class="seller-link">
                            <img src="{{asset('img/user.png')}}}" alt="" >
                            <strong>{{$product->merchant->arabic_name}}-{{$product->merchant->english_name}}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="product-tab">
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">@lang('messages.description')</a></li>
                            <li><a data-toggle="tab" href="#tab2">@lang('messages.Reviews') ({{count($product->reviews)}})</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane fade in active">
                                <p>{{$product->description}}</p>
                            </div>
                            <div id="tab2" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="product-reviews">

                                            @foreach($product->reviews as $review)
{{--                                                @php dd($review->CUSTOMER->name)@endphp--}}

                                                <div class="single-review">
                                                    <div class="review-heading">
                                                        <div style="color:#30323A;"><i class="fa fa-user" style="color:#30323A;"></i> {{$review->customer->name}}</div>
                                                        <div style="color:#30323A;"><i class="fa fa-clock" style="color:#30323A;"></i> {{date('d-m-Y', strtotime($review->created_at))}}</div>
                                                        <div class="review-rating pull-right">
                                                            @for($i = 0 ; $i < $review->review ; $i++)
                                                                <i class="fa fa-star"></i>
                                                            @endfor
                                                            @for($i = 0 ; $i < 5- $review->review ; $i++)
                                                                <i class="fa fa-star-o empty"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                <div class="review-body">
                                                    <p>{{$review->comment}}</p>
                                                </div>
                                            </div>
                                            @endforeach



{{--                                            <ul class="reviews-pages">--}}
{{--                                                <li class="active">1</li>--}}
{{--                                                <li><a href="#">2</a></li>--}}
{{--                                                <li><a href="#">3</a></li>--}}
{{--                                                <li><a href="#"><i class="fa fa-caret-right"></i></a></li>--}}
{{--                                            </ul>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-uppercase">@lang('messages.Write Your Review')</h4>
                                        <p>@lang('messages.Your email address will not be published').</p>
                                        <form class="review-form" action="{{url('/customer/product/add_review/'.$product->id)}}" method="post">
                                            @csrf
{{--                                            <input class="input form-control" type="hidden" name="email" placeholder="Email Address" >--}}
{{--                                            <input class="input form-control" type="hidden" name="email" placeholder="Email Address" >--}}
                                            <div class="form-group">
                                                <textarea class="input form-control" name="comment" placeholder="Your review"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-rating">
                                                    <strong class="text-uppercase">@lang('messages.Your Rating'): </strong>
                                                    <div class="stars">
                                                        <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                                                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                                                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="primary-btn">@lang('messages.Submit')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Product Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="exampleModalLabel">You are not a member</h3>
            </div>
            <div class="modal-body">
                please login or signin to add this product in your favourites
            </div>
            <div class="modal-footer">
                <a href="{{url('/login/customer')}}" type="button" class="btn primary-btn">Signin</a>
            </div>
        </div>
    </div>
</div>
@endsection
