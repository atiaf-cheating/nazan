@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp

        <div class="row  @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2><i class="fa fa-edit @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp; @lang('messages.edit promotion')</h2>
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
        <form method="post" action="{{url('/promotions/update/'.$promotion->id)}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group   @if($language == 'ar') rtl @endif" id="select_cat">
                <label for="product_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.product')</label>
                <select name="product_id" id="product_id" class=" cat_id browser-default custom-select">
                    @foreach($products as $product)
                        <option value="{{$product->id}}" @if($promotion->product_id == $product->id)selected@else '' @endif>{{$product->arabic_name .'-'. $product->english_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group @if($language == 'ar') rtl @endif">
                <label for="photo">@lang('messages.photo')</label>
                <img src=" {{URL::asset("images/promotions/".$promotion->image_url) }}" style="width: 15%;"><br><br>
                <input type="file" name="image_url" value="{{$promotion->image_url}}" class="form-control-file @if($language == 'ar') rtl @endif" id="photo" placeholder="upload photo" >
            </div>
{{--            <div class="form-group @if($language == 'ar') rtl @endif">--}}
{{--                <label for="expires_in_days" class=" @if($language == 'ar') rtl @endif">@lang('messages.days of expiry')</label>--}}
{{--                <input type="text"  value="{{$promotion->expires_in_days}}" name="expires_in_days"  class="form-control  @if($language == 'ar') rtl @endif" id="expires_in_days" placeholder="enter email" >--}}
{{--            </div>--}}
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="expiry_date" class=" @if($language == 'ar') rtl @endif">@lang('messages.expiry date')</label>
                <input type="date" value="{{$promotion->expiry_date}}" name="expiry_date"  class="form-control @if($language == 'ar') rtl @endif" id="expiry_date" placeholder="enter phone">
            </div>
            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button>
        </form>
@endsection
