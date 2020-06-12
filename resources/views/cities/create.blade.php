@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        @if($parent_city_id == 0)
            <div class="col  @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-plus @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp;@lang('messages.create new')</h2>
            </div>
        @endif
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
    <form method="post" action="{{route('cities.store')}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
        {{ csrf_field() }}
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="arabic-name" class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</label>
            <input type="text" value="{{old('arabic_name')}}" name="arabic_name" class="form-control  @if($language == 'ar') rtl @endif" id="arabic-name" aria-describedby="emailHelp" placeholder="أدخل الاسم" required>
        </div>
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="english-name" class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</label>
            <input type="text"  value="{{old('english_name')}}" name="english_name"  class="form-control  @if($language == 'ar') rtl @endif" id="english-name" placeholder="@lang('enter name')" required>
        </div>
        <div class="form-group  @if($language == 'ar') rtl @endif">
            <label for="order" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
            <input type="text" value="{{old('order')}}" name="order"  class="form-control @if($language == 'ar') rtl @endif" id="order" placeholder="@lang('enter order')">
        </div>
        <div class="form-group  @if($language == 'ar') rtl @endif">
            <label for="delivery_price" class=" @if($language == 'ar') rtl @endif">@lang('messages.delivery price')</label>
            <input type="text" value="{{old('delivery_price')}}" name="delivery_price"  class="form-control @if($language == 'ar') rtl @endif" id="delivery_price" placeholder="@lang('enter delivery price')">
        </div>
        <div class="form-group  @if($language == 'ar') rtl @endif">
                <input type="text" value="{{$parent_city_name}}" class="form-control @if($language == 'ar') rtl @endif"  hidden>
                <input type="text" value="{{$parent_city_id}}" name="parent_city_id" id="Parent_cat" class="form-control @if($language == 'ar') rtl @endif"  hidden>

        </div>

        <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button>
    </form>
@endsection
