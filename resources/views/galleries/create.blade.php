@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col  @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-plus @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp;@lang('messages.create new')</h2>
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
        <form method="post" action="{{route('galleries.store')}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}

            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="large_image" class=" @if($language == 'ar') rtl @endif">@lang('messages.large image')</label>
                <input type="file"  name="large_image"  class="form-control @if($language == 'ar') rtl @endif" id="large_image" placeholder="enter order">
            </div>

            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="phone_image" class=" @if($language == 'ar') rtl @endif">@lang('messages.small image')</label>
                <input type="file"  name="phone_image"  class="form-control @if($language == 'ar') rtl @endif" id="phone_image" placeholder="enter order">
            </div>



            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button>
        </form>
@endsection
