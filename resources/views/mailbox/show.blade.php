@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.suggestions and complains')</h2>
        </div>
        {{--        <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">--}}
        {{--            <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('merchants/create')}}"> @lang('messages.add new')</a>--}}
        {{--        </div>--}}

    </div>

    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('id'):</label>
        <h3 class="form-control">{{$message->id}}
    </h3>
    </div>
    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('category'):</label>

        <h3 class="form-control">{{$message->category}}
    </h3>
    </div>
    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('name'):</label>

        <h3 class="form-control">{{$message->name}}
    </h3>
    </div>
    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('email'):</label>

        <h3 class="form-control">{{$message->email}}
    </h3>
    </div>
    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('message'):</label>

        <h3 class="form-control">{{$message->message}}
    </h3>
    </div>
    <div class="form-group @if($language == 'ar') rtl @endif">
        <label for="" class="col-md-4 col-form-label text-md-right">@lang('added date'):</label>

        <h3 class="form-control">{{$message->created_at}}
    </h3>
    </div>

@endsection
