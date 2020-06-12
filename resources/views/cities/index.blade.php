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
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.cities')</h2>
            </div>
{{--            @if(count($cities) == 0)--}}
                <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                    <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('cities/create/0')}}"> @lang('messages.add new')</a>
                </div>
{{--            @endif--}}

        </div>

        <table class="table table-bordered cities-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.delivery price')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($cities as $city)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$city->arabic_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$city->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$city->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$city->delivery_price}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">
                        @if($city->parent_city_id == 0)
                            <a href="{{url('/cities/'.$city->id)}}" class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.areas')</a>
                        @endif
                        <a href="{{url('cities/edit/'.$city->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                        <a href="{{url('cities/activate/'.$city->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($city->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                        <a href="{{url('cities/delete/'.$city->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                        @if($city->parent_city_id == 0)
                            <a href="{{url('cities/create/'.$city->id)}}" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.add area')</a>
                        @endif
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cities->links() }}
@endsection
