@extends('sizes.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.sizes')</h2>
            </div>
            <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('sizes/create/'.$cat_id)}}"> @lang('messages.add new')</a>
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
            @foreach($sizes as $size)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$size->arabic_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$size->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$size->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">
                        <a href="{{url('sizes/edit/'.$size->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
{{--                        <a href="{{url('sizes/activate/'.$size->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($size->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>--}}
                        <a href="{{url('sizes/delete/'.$size->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
{{--                        <a id="add_sizes_btn"  href="{{url('sizes/create/'.$cat_id)}}" class="btn btn-primary @if($language == 'ar') rtl @endif">@lang('messages.add size')</a>--}}
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $sizes->links() }}
    <script>
        // document.getElementById("add_sizes_btn").addEventListener("click", function(event){
        //     event.preventDefault();
        // });
    </script>
@endsection
