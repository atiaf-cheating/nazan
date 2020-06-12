{{--@extends('merchant.layout')--}}
{{--@section('content')--}}
{{--    @php--}}
{{--        $language = App::getLocale();--}}
{{--        if(isset($parent_cat_id)){--}}
{{--            $parent_id = $parent_cat_id;--}}
{{--        }else{--}}
{{--            $parent_id = 0;--}}
{{--        }--}}
{{--    @endphp--}}
{{--    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">--}}
{{--        <div class="col @if($language == 'ar') rtl @endif">--}}
{{--            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.details')</h2>--}}
{{--        </div>--}}

{{--    </div>--}}


{{--    <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">--}}
{{--        <thead class="thead-light">--}}
{{--        <tr class=" @if($language == 'ar') rtl @endif">--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.Product id')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product name')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product description')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category name')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.parent category')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.brand name')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product color')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product color name')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product size')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product size name')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product size category')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product price')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product price discount')</th>--}}
{{--        </tr>--}}

{{--        </thead>--}}
{{--        <tbody class=" @if($language == 'ar') rtl @endif">--}}

{{--        @foreach($order->orderProducts as $orderProduct)--}}
{{--            --}}{{--@php                dd($product->category)@endphp--}}

{{--            <tr class=" @if($language == 'ar') rtl @endif">--}}
{{--                <th class=" @if($language == 'ar') rtl @endif"> {{$orderProduct->product_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$orderProduct->product_arabic_name .'-'.$orderProduct->product_english_name}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$orderProduct->product_description}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif"--}}
{{--                    style="width: 6%; height: 6%;"--}}
{{--                >--}}
{{--                    <img src=" {{URL::asset("images/products/". $orderProduct->product_image_url) }}" style="width: 15%;"><br><br>--}}
{{--                </th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">{{$orderProduct->product_cat_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_category_arabic_name .'-'. $orderProduct->product_category_english_name}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_parent_cat_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_brand_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_brand_arabic_name .'-'. $orderProduct->product_brand_english_name}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_color_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_color_arabic_name}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_arabic_name .'-'. $orderProduct->product_size_english_name}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_cat_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_price}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_price_discount}}</th>--}}

{{--            </tr>--}}
{{--        @endforeach--}}

{{--        --}}{{--        {{ $order->orderProducts->links() }}--}}

{{--        </tbody>--}}
{{--    </table>--}}
{{--    <a href="#" class="btn btn-info @if($language == 'ar') rtl @endif">print</a>--}}

{{--        <br>--}}
{{--@endsection--}}










{{--@extends('merchant.layout')--}}
{{--@section('content')--}}
{{--    @php--}}
{{--        $language = App::getLocale();--}}
{{--       --}}
{{--    @endphp--}}
{{--    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">--}}
{{--        <div class="col @if($language == 'ar') rtl @endif">--}}
{{--            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.details')</h2>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--    <table class="table">--}}
{{--        <thead class="thead-dark">--}}
{{--        <tr>--}}
{{--            <th scope="col">#</th>--}}
{{--            <th scope="col">First</th>--}}
{{--            <th scope="col">Last</th>--}}
{{--            <th scope="col">Handle</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>Mark</td>--}}
{{--            <td>Otto</td>--}}
{{--            <td>@mdo</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">2</th>--}}
{{--            <td>Jacob</td>--}}
{{--            <td>Thornton</td>--}}
{{--            <td>@fat</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">3</th>--}}
{{--            <td>Larry</td>--}}
{{--            <td>the Bird</td>--}}
{{--            <td>@twitter</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <table class="table">--}}
{{--        <thead class="thead-light">--}}
{{--        <tr>--}}
{{--            <th scope="col">#</th>--}}
{{--            <th scope="col">First</th>--}}
{{--            <th scope="col">Last</th>--}}
{{--            <th scope="col">Handle</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>Mark</td>--}}
{{--            <td>Otto</td>--}}
{{--            <td>@mdo</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">2</th>--}}
{{--            <td>Jacob</td>--}}
{{--            <td>Thornton</td>--}}
{{--            <td>@fat</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">3</th>--}}
{{--            <td>Larry</td>--}}
{{--            <td>the Bird</td>--}}
{{--            <td>@twitter</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--@endsection--}}
{{--@extends('merchant.layout')--}}
{{--@section('content')--}}
{{--    @php dd($order) @endphp--}}
{{--    <table class="table">--}}
{{--        <thead class="thead-dark">--}}
{{--        <tr>--}}
{{--            <th scope="col">#</th>--}}
{{--            <th scope="col">First</th>--}}
{{--            <th scope="col">Last</th>--}}
{{--            <th scope="col">Handle</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>Mark</td>--}}
{{--            <td>Otto</td>--}}
{{--            <td>@mdo</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">2</th>--}}
{{--            <td>Jacob</td>--}}
{{--            <td>Thornton</td>--}}
{{--            <td>@fat</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">3</th>--}}
{{--            <td>Larry</td>--}}
{{--            <td>the Bird</td>--}}
{{--            <td>@twitter</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <table class="table">--}}
{{--        <thead class="thead-light">--}}
{{--        <tr>--}}
{{--            <th scope="col">#</th>--}}
{{--            <th scope="col">First</th>--}}
{{--            <th scope="col">Last</th>--}}
{{--            <th scope="col">Handle</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>Mark</td>--}}
{{--            <td>Otto</td>--}}
{{--            <td>@mdo</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">2</th>--}}
{{--            <td>Jacob</td>--}}
{{--            <td>Thornton</td>--}}
{{--            <td>@fat</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th scope="row">3</th>--}}
{{--            <td>Larry</td>--}}
{{--            <td>the Bird</td>--}}
{{--            <td>@twitter</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    @endsection--}}






@extends('merchant.layout')
@section('merchant-content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</h2>
        </div>
        {{--            @if(count($orders) == 0)--}}
        {{--        <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">--}}
        {{--            <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('merchant/control/products/create/')}}"> @lang('messages.add new')</a>--}}
        {{--        </div>--}}
        {{--            @endif--}}

    </div>

    <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
        <thead>
        <tr class=" @if($language == 'ar') rtl @endif">
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.status')</th>
{{--                            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.merchant id')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.customer name')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.customer email')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.customer phone')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.city id')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.parent city id')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.city arabic name')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.city english name')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.delivery price')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.street')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.building number')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.coupon code')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.coupon discount percentage')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.coupon expiry date')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>--}}
        </tr>

        </thead>
        <tbody class=" @if($language == 'ar') rtl @endif">

            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">
                    @if($order->status == 1)
                        review
                    @elseif($order->status == 2)
                        preparation
                    @elseif($order->status == 3)
                        delivery
                    @elseif($order->status == 4)
                        delivered
                    @endif
                </th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->customer_name}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->customer_email}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->customer_phone}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->city_id}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->parent_city_id}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->city_arabic_name}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->city_english_name}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->delivery_price}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->street}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->building_number}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->coupon_code}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->coupon_discount_percentage}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$order->coupon_expiry_date}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif">--}}
{{--                    <a href="{{url('/merchant/control/orders/edit-status/'.$order->id)}}"  class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.edit status')</a>--}}
{{--                    <a href="{{url('/merchant/control/orders/details/'.$order->id)}}" class="btn btn-primary @if($language == 'ar') rtl @endif">@lang('messages.details')</a>--}}
{{--                </th>--}}
            </tr>
        </tbody>
    </table>
@endsection
