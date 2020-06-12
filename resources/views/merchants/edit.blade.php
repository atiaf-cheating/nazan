@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp

        <div class="row  @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-edit @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp; @lang('messages.edit merchant')</h2>
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
        <form method="post" action="{{url('/merchants.update/'.$merchant->id)}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="arabic-name">@lang('messages.arabic name')</label>
                <input type="text" value="{{$merchant->arabic_name}}" name="arabic_name" class="form-control @if($language == 'ar') rtl @endif" id="arabic-name" aria-describedby="emailHelp" placeholder="أدخل الاسم" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="english-name">@lang('messages.english name')</label>
                <input type="text"  value="{{$merchant->english_name}}" name="english_name"  class="form-control @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter name" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="user-name" class=" @if($language == 'ar') rtl @endif">@lang('messages.user name')</label>
                <input type="text"  value="{{$merchant->user_name}}" name="user_name"  class="form-control  @if($language == 'ar') rtl @endif" id="user-name" placeholder="enter user name" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="email" class=" @if($language == 'ar') rtl @endif">@lang('messages.email')</label>
                <input type="text"  value="{{$merchant->email}}" name="email"  class="form-control  @if($language == 'ar') rtl @endif" id="email" placeholder="enter email" >
            </div>
{{--            <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                <label for="password" class=" @if($language == 'ar') rtl @endif">@lang('messages.password')</label>--}}
{{--                <input type="password"  name="password" value="{{$merchant->password}}" class="form-control @if($language == 'ar') rtl @endif" id="password" placeholder="enter password">--}}
{{--            </div>--}}
{{--            <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                <label for="confirm-password" class=" @if($language == 'ar') rtl @endif">@lang('messages.confirm password')</label>--}}
{{--                <input type="password" name="c_password" value="{{$merchant->password}}" class="form-control @if($language == 'ar') rtl @endif" id="confirm-password" placeholder="enter confirmation password">--}}
{{--            </div>--}}
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="phone" class=" @if($language == 'ar') rtl @endif">@lang('messages.phone')</label>
                <input type="text" name="phone" value="{{$merchant->phone}}" class="form-control @if($language == 'ar') rtl @endif" id="phone" placeholder="enter phone">
            </div>
            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button>
        </form>
@endsection
