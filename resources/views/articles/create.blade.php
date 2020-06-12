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
        <form method="post" action="{{route('articles.store')}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="title" class=" @if($language == 'ar') rtl @endif">@lang('messages.title')</label>
                <input type="text" value="{{old('title')}}" name="title" class="form-control  @if($language == 'ar') rtl @endif" id="title" aria-describedby="emailHelp" placeholder="أدخل العنوان" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="body" class=" @if($language == 'ar') rtl @endif">@lang('messages.body')</label>
                <textarea type="text"  value="{{old('body')}}" name="body"  class="form-control  @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter body" required></textarea>
            </div>


            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="order" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
                <input type="text"  name="order"  class="form-control @if($language == 'ar') rtl @endif" id="order" placeholder="enter order">
            </div>
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="photo" class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</label>
                <input type="file"  name="image_url"  class="form-control @if($language == 'ar') rtl @endif" id="photo" placeholder="enter order">
            </div>



            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button>
        </form>
@endsection
