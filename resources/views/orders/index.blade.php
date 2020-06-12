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
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.orders')</h2>
            </div>
{{--            @if(count($products) == 0)--}}
{{--                <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">--}}
{{--                    <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('products/create/')}}"> @lang('messages.add new')</a>--}}
{{--                </div>--}}
{{--            @endif--}}

        </div>

        <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead class="thead-light">
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.status')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.merchant id')</th>
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
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($orders as $order)

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
                    <th class=" @if($language == 'ar') rtl @endif">{{$order->merchant_id}}</th>
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
                    <th class=" @if($language == 'ar') rtl @endif">
                        <a href="{{url('orders/edit-status/'.$order->id)}}"  class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.edit status')</a>
                        <a href="{{url('orders/details/'.$order->id)}}" class="btn btn-primary @if($language == 'ar') rtl @endif">@lang('messages.details')</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
@endsection
