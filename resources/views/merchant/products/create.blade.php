@extends('merchant.layout')
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
    <form method="post" action="{{url('/merchant/control/products.store')}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
        {{ csrf_field() }}
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="arabic-name" class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</label>
            <input type="text" value="{{old('arabic_name')}}" name="arabic_name" class="form-control  @if($language == 'ar') rtl @endif" id="arabic-name" aria-describedby="emailHelp" placeholder="أدخل الاسم" required>
        </div>
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="english-name" class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</label>
            <input type="text"  value="{{old('english_name')}}" name="english_name"  class="form-control  @if($language == 'ar') rtl @endif" id="english-name" placeholder="enter name" required>
        </div>
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="description" class=" @if($language == 'ar') rtl @endif">@lang('messages.description')</label>
            <textarea type="text"  value="{{old('description')}}" name="description"  class="form-control  @if($language == 'ar') rtl @endif" id="description" placeholder="enter description" ></textarea>
        </div>
        <div class="form-group   @if($language == 'ar') rtl @endif" id="select_cat">
            <label for="cat_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</label>
            <select name="cat_id" id="cat_id" onchange="showSubCategories(is_main = 1)" class=" cat_id browser-default custom-select">
                <option selected></option>
            @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->arabic_name .'-'. $category->english_name}}</option>
                @endforeach
            </select>
        </div>
        <input id="final_sub_cat" name="final_sub_cat" hidden>
        <div class="form-group  @if($language == 'ar') rtl @endif">
            <label for="merchant_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.merchant')</label>
            <select name="merchant_id" class="browser-default custom-select">
                @foreach($merchants as $merchant)
                    <option value="{{$merchant->id}}">{{$merchant->arabic_name .'-'. $merchant->english_name}}</option>
                @endforeach
            </select>
        </div>
{{--        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--            <label for="merchant_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.color')</label>--}}
{{--            <select name="merchant_id" class="browser-default custom-select">--}}
{{--            @foreach($colors as $color)--}}
{{--                    <option value="{{$color->id}}">{{$color->arabic_name .'-'. $color->english_name}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}


{{--        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--            <label for="merchant_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.size')</label>--}}
{{--            <select name="merchant_id" class="browser-default custom-select">--}}
{{--                @foreach($sizes as $size)--}}
{{--                    <option value="{{$size->id}}">{{$size->arabic_name .'-'. $size->english_name}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

        <div class="form-group  @if($language == 'ar') rtl @endif">
            <label for="brand_id" class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</label>
            <select name="brand_id" id="brand_id" class="browser-default custom-select">
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->arabic_name .'-'. $brand->english_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group  @if($language == 'ar') rtl @endif">
            <label for="order" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
            <input type="text" value="{{old('order')}}" name="order"  class="form-control @if($language == 'ar') rtl @endif" id="order" placeholder="enter order">
        </div>
{{--        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--            <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.parent category')</label>--}}
{{--                <input type="text" value="{{$parent_cat_name}}" class="form-control @if($language == 'ar') rtl @endif"  hidden>--}}
{{--                <input type="text" value="{{$parent_cat_id}}" name="parent_cat_id" id="Parent_cat" class="form-control @if($language == 'ar') rtl @endif"  hidden>--}}
{{--            <select name="parent_cat_id" class="browser-default custom-select">--}}
{{--                @foreach($categories as $category)--}}
{{--                    <option value="{{$category->id}}">{{$category->arabic_name .'-'. $category->english_name}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="photo" class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</label>
            <input type="file" name="image_url"  class="form-control-file @if($language == 'ar') rtl @endif" id="photo" placeholder="upload photo" required>
        </div>

        <div class="input-group control-group increment">
            <input type="file" name="filename[]" class="form-control">
            <div class="input-group-btn">
                <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus "></i>add</button>
            </div>
        </div>

        <br>
        <div class="clone hide">
            <div class="input-group control-group increment">
                <input type="file" name="filename[]" class="form-control">
                <div class="input-group-btn">
                    <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove "></i>remove</button>
                </div>
            </div>
        </div>
<br><br>
        <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button>
        <br><br>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var i = 0;
            $(".btn-success").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function () {
                $(this).parents(".control-group").remove();
            });
        });

        var subCat_1 = 0;
        function showSubCategories(is_main){
            console.log('ggggggg');
            // $('.cat_id').change(function(){
            if(is_main === 1){
                $id = $("#cat_id").children("option:selected").val();
            }else{
                $id = $("#cat_id_"+ subCat_1).children("option:selected").val();
            }
            $("#final_sub_cat").val($id);
            console.log('id',$id);
            $.ajax({
                method: "get",
                url: "/sub-categories",
                data: {
                    id: $id ,
                    "_token": "{{ csrf_token() }}"
                }
            }).done(function($data) {
                console.log($data);
                if(Object.keys($data).length !== 0){
                    subCat_1++;
                    $newSelectOpenning = `<div class="form-group select_cat">` +
                     `<label for="cat_id">sub category</label>` +
                    `<select name="cat_id" onchange="showSubCategories(is_main = 0)" id="cat_id_${subCat_1}" class="browser-default cat_id custom-select">`+
                    `<option selected></option>`;

                    $("#select_cat").after($newSelectOpenning);

                    $.each( $data, function( key, value ) {
                        $option = `<option class="sub_cat_option" value="${value.id}">${value.arabic_name} - ${value.english_name}</option>`;
                        $("#cat_id_"+subCat_1).append($option);
                        console.log( key + ": " + value.arabic_name );
                    });
                    $("#cat_id_"+subCat_1 + " .sub_cat_option:last-child").after('</select></div>');
                    // $(".sub_cat_option").
                }
            })
            .fail(function() {
                alert( "error" );
            })
            // });
        }

    </script>
@endsection
