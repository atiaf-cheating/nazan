@extends('sizes.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp

        <div class="row  @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-edit @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp; @lang('messages.edit size')</h2>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger @if($language == 'ar') rtl @endif" style="width: 90%;margin-left: 2%;">
                <ul class=" @if($language == 'ar') rtl @endif">
                    @foreach ($errors->all() as $error)
                        <li class=" @if($language == 'ar') rtl @endif">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{url('/sizes.update/'.$size->id)}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="arabic-name">@lang('messages.arabic name')</label>
                <input type="text" value="{{$size->arabic_name}}" name="arabic_name" class="form-control @if($language == 'ar') rtl @endif" id="arabic-name" aria-describedby="emailHelp" placeholder="أدخل الاسم" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="english-name">@lang('messages.english name')</label>
                <input type="text"  value="{{$size->english_name}}" name="english_name"  class="form-control @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter name" required>
            </div>

            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="order" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
                <input type="text"  name="order" value="{{$size->order}}" class="form-control @if($language == 'ar') rtl @endif" id="order" placeholder="enter order">
            </div>
            <input type="text"  name="cat_id" value="{{$size->cat_id}}" hidden>

            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button>
        </form>
@endsection
