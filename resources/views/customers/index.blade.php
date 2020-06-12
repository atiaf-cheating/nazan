@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.customers')</h2>
            </div>
{{--            <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">--}}
{{--                <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('customers/create')}}"> @lang('messages.add new')</a>--}}
{{--            </div>--}}

        </div>

        <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.email')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.phone')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.active')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($customers as $customer)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$customer->name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$customer->email}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$customer->phone}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$customer->active}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">
{{--                        <a href="{{url('customers/edit/'.$customer->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>--}}
                        <a href="{{url('customer/activate/'.$customer->id)}}"  onclick="return confirm('Are you sure?')"  class="btn btn-warning @if($language == 'ar') rtl @endif">@if($customer->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
{{--                        <a href="{{url('customers/delete/'.$customer->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>--}}
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $customers->links() }}
@endsection
