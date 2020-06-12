@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.brands')</h2>
            </div>
            <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('brands/create')}}"> @lang('messages.add new')</a>
            </div>

        </div>

        <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($brands as $brand)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$brand->arabic_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$brand->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$brand->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">
                        <a href="{{url('brands/edit/'.$brand->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                        <a href="{{url('brands/activate/'.$brand->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($brand->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                        <a href="{{url('brands/delete/'.$brand->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $brands->links() }}
@endsection
