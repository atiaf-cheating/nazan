@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
        if(isset($parent_cat_id)){
            $parent_id = $parent_cat_id;
        }else{
            $parent_id = 0;
        }
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.details')</h2>
        </div>

    </div>


    <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
        <thead class="thead-light">
        <tr class=" @if($language == 'ar') rtl @endif">
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.Product id')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.description')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.parent category')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product color')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.color')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product size')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.size')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product size category')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.discount')</th>
        </tr>

        </thead>
        <tbody class=" @if($language == 'ar') rtl @endif">

        @foreach($order->orderProducts as $orderProduct)
            {{--@php                dd($product->category)@endphp--}}

            <tr class=" @if($language == 'ar') rtl @endif">
{{--                <th class=" @if($language == 'ar') rtl @endif"> {{$orderProduct->product_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif">{{$orderProduct->product_arabic_name .'-'.$orderProduct->product_english_name}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$orderProduct->product_description}}</th>
                <th class=" @if($language == 'ar') rtl @endif"
{{--                    style="width: 6%; height: 6%;"--}}
                >
                    <img src=" {{URL::asset("images/products/". $orderProduct->product_image_url) }}" style="width: 15%;"><br><br>
                </th>
{{--                <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">{{$orderProduct->product_cat_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_category_arabic_name .'-'. $orderProduct->product_category_english_name}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_parent_cat_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_brand_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_brand_arabic_name .'-'. $orderProduct->product_brand_english_name}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_color_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_color_arabic_name}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_arabic_name .'-'. $orderProduct->product_size_english_name}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_size_cat_id}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_price}}</th>
                <th class=" @if($language == 'ar') rtl @endif" >{{$orderProduct->product_price_discount}}</th>

            </tr>
        @endforeach

        {{--        {{ $order->orderProducts->links() }}--}}

        </tbody>
    </table>
    <a href="#" class="btn btn-info @if($language == 'ar') rtl @endif">print</a>

        <br>
@endsection
