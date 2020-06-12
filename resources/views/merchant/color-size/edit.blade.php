@extends('no-sidebar-layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col">
            <h2 style="color:#007BFF;">{{$product_name}}</h2>
            <h4><i class="fa fa-plus @if($language == 'ar') rtl @endif"
                   style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i>
                &nbsp;@lang('messages.edit color/size')
            </h4>
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
    <form method="post" action="{{url('/merchant/control/products/color-size/update')}}" id="color_size_form" enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif"
          style="width: 90%;border-top: 4px solid #007BFF;border-bottom: 4px solid #007BFF; padding: 3%; margin: 2%;background: white;">
        {{ csrf_field() }}
        <input name="product_id" value="{{$product_id}}" hidden>
        <input name="cat_id" value="{{$cat_id}}" hidden>
        <input name="color_product" value="{{$colorProduct->id}}" hidden>
        <div class="form-group row  @if($language == 'ar') rtl @endif">
            <div class="col-md-7">
                <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">color : {{$colorProduct->colors->arabic_name .'-'.$colorProduct->colors->english_name}}</label>
{{--                <select  name="color" onchange="showOrderInput()" class="browser-default custom-select">--}}
{{--                    @foreach($colors as $color)--}}
{{--                        <option value="{{$color->id}}" @if($colorProduct->color_id == $color->id) selected @endif>{{$color->arabic_name .'-'. $color->english_name}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                <input vlaue="{{$colorProduct->color_id}}" disabled>--}}
            </div>
            <div class="col-md-5">
                <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
                <input id="size_input" name="color_order" class="form-control" type="text" class="" value="{{$colorProduct->order}}">
            </div>
        </div>
        <hr>
{{--            <div class="row">--}}
{{--                <div class="form-group col-md-4 form-inline @if($language == 'ar') rtl @endif">--}}
{{--                    <input id="size_input" name="size_id" type="checkbox" class="" value="{{$size->id}}">--}}
{{--                    <label for="size_input" class=" @if($language == 'ar') rtl @endif">{{$size->arabic_name .'-'. $size->english_name}}</label>--}}
{{--                </div>--}}
{{--                <div class="form-inline col-md-8">--}}
{{--                    <div class="form-group   @if($language == 'ar') rtl @endif">--}}
{{--                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</label>--}}
{{--                        <input type="text" name="price" value="{{$colorProduct->price}}">--}}
{{--                    </div>--}}
{{--                    <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>--}}
{{--                        <input type="text" name="order" value="{{$colorProduct->order}}">--}}
{{--                    </div>--}}
{{--                    <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</label>--}}
{{--                        <input type="text" name="quantity" value="{{$colorProduct->quantity}}">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <br><hr>--}}
        <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button><br>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>

    <script>
        function showOrderInput() {
            var data = $("#color_size_form").serialize();
            console.log(data);
        }
    </script>
@endsection
