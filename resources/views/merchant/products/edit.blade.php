@extends('merchant.layout')
@section('merchant-content')
    @php
        $language = App::getLocale();
    @endphp

        <div class="row  @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-edit @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp; @lang('messages.edit product')</h2>
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
        <form method="post" action="{{url('/merchant/control/products.update/'.$product->id)}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="arabic-name">@lang('messages.arabic name')</label>
                <input type="text" value="{{$product->arabic_name}}" name="arabic_name" class="form-control @if($language == 'ar') rtl @endif" id="arabic-name" aria-describedby="emailHelp" placeholder="أدخل الاسم" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="english-name">@lang('messages.english name')</label>
                <input type="text"  value="{{$product->english_name}}" name="english_name"  class="form-control @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter name" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="english-name">@lang('messages.description')</label>
                <input type="text"  value="{{$product->description}}" name="description"  class="form-control @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter description" required>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="order">@lang('messages.order')</label>
                <input type="text" value="{{$product->order}}" name="order"  class="form-control @if($language == 'ar') rtl @endif" id="order" placeholder="enter order">
            </div>
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="brand_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</label>
                <select name="brand_id" id="brand_id" class="browser-default custom-select">
                    @foreach($brands as $brand)
                        <option value="{{$brand->id}}" @if($product->brand_id == $brand->id) selected @endif>{{$brand->arabic_name .'-'. $brand->english_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group  @if($language == 'ar') rtl @endif">
{{--                <label for="merchant_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.merchant')</label>--}}
                <input name="merchant_id" type="hidden" value="{{$merchant_id->id}}">
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="photo">@lang('messages.photo')</label>
                <img src=" {{URL::asset("images/products/".$product->image_url) }}" style="width: 15%;"><br><br>
                <input type="file" name="image_url" value="{{$product->image_url}}" class="form-control-file @if($language == 'ar') rtl @endif" id="photo" placeholder="upload photo" >
            </div>
            <input name="cat_id" value="{{$product->cat_id}}" hidden>

            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button>
        </form>
@endsection
