@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.coupons')</h2>
        </div>
        <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
            <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('coupons/create')}}"> @lang('messages.add new')</a>
        </div>

    </div>

    <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
        <thead>
        <tr class=" @if($language == 'ar') rtl @endif">
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.code')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.discount percentage')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.expiry date')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
        </tr>

        </thead>
        <tbody class=" @if($language == 'ar') rtl @endif">
        @foreach($coupons as $coupon)
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif"> {{$coupon->code}}</th>
                <th class=" @if($language == 'ar') rtl @endif"> {{$coupon->discount_percentage}}</th>
                <th class=" @if($language == 'ar') rtl @endif" > {{$coupon->expiry_date}}</th>
                <th class=" @if($language == 'ar') rtl @endif">
                    <a href="{{url('coupons/edit/'.$coupon->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                    <a href="{{url('coupons/activate/'.$coupon->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($coupon->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                    <a href="{{url('coupons/delete/'.$coupon->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $coupons->links() }}
@endsection
