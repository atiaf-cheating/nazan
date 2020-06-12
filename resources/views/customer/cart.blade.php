@extends('customer.layout')
@section('content')
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
            <li class="active">@lang('messages.My cart')</li>
        </ul>
    </div>
</div>

<!-- section -->
<div class="section aboutus cart">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title">@lang('messages.My cart')</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="order-summary clearfix">
                    <table class="shopping-cart-table table">
                        <thead>
                        <tr>
                            <th>@lang('messages.product')</th>
                            <th></th>
                            <th class="text-center">@lang('messages.price')</th>
                            <th class="text-center">@lang('messages.quantity')</th>
                            <th class="text-center">@lang('messages.Total')</th>
                            <th class="text-right"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($cart))
                            @php $totalPrice = 0 @endphp
                            @foreach($cart->products as $product)
{{--                                @php--}}
{{--                                    if($product['discount'] != null){--}}
{{--                                       $totalPrice+= $product['price'] - $product['price']*$product['discount'] / 100;--}}
{{--                                    }else{--}}
{{--                                       $totalPrice+= $product['price'];--}}
{{--                                    }--}}
{{--                                @endphp--}}

                                <tr>
                                    <td class="thumb"><img src="{{asset('images/products/'.$product['image_url'])}}" alt=""></td>
                                    <td class="details">
                                        <a href="#">{{$product['arabic_name']}}-{{$product['english_name']}}</a>
                                    </td>
                                    <td class="price text-center">

                                        <strong>$
                                            @if($product['discount'] != null)
                                                {{$product['price'] - $product['price']*$product['discount'] / 100}}
                                                </strong><br>
                                                <del class="font-weak">
                                                    <small>
                                                        ${{$product['price']}}
                                                    </small>
                                                </del>
                                            @else
                                                {{$product['price']}}
                                                </strong><br>
                                            @endif

                                    </td>
                                    <td class="qty text-center"><input class="input" type="number" value="{{$product['quantity']}}"></td>
                                    <td class="total text-center">
                                        <strong class="primary-color">
                                            @if($product['discount'] != null)
                                                ${{$product['price'] - $product['price']*$product['discount'] / 100}}
                                            @else
                                                {{$product['price']}}
                                            @endif
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <form method="post" action="{{url('customer/remove_from_cart')}}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product['id']}}">
                                            <button type="submit" class="cancel-btn"><i class="fa fa-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="empty" colspan="3"></th>
                            <th>TOTAL</th>
                            <th colspan="2" class="total">${{$cart->totalPrice}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pull-right">
                        @if(isset($cart) && count($cart->products)> 0)
                             <a href="{{url('customer/checkout')}}" class="btn primary-btn">@lang('messages.Check Out')</a>
                        @else
                            <a href="#" class="btn primary-btn" disabled="true">@lang('messages.Check Out')</a>
                        @endif
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
