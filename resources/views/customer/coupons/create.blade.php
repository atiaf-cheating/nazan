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
        <form method="post" action="{{route('coupons.store')}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <div class="form-group  row @if($language == 'ar') rtl @endif" id="select_cat">
                <label for="code" class="col @if($language == 'ar') rtl @endif">@lang('messages.code')</label>&nbsp;
                <div class="col-md-4">
                    <input type="text" name="code"  class="form-control @if($language == 'ar') rtl @endif" id="code" placeholder="enter code">
                </div>&nbsp;
                <div class="col-md-4">
                     or <button type="button" class="btn btn-primary generate-code @if($language == 'ar') rtl @endif" onclick="generateCode()" style="float:right;">@lang('messages.generate code automatic')</button>
                </div>&nbsp;
            </div>
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="discount_percentage" class=" @if($language == 'ar') rtl @endif">@lang('messages.discount percentage')</label>
                <input type="text" name="discount_percentage"  class="form-control @if($language == 'ar') rtl @endif" id="discount_percentage" placeholder="enter discount percentage">
            </div>
{{--            <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                <label for="expires_in_days" class=" @if($language == 'ar') rtl @endif">@lang('messages.days of expiry')</label>--}}
{{--                <input type="text" name="expires_in_days"  class="form-control @if($language == 'ar') rtl @endif" id="expires_in_days" placeholder="enter phone">--}}
{{--            </div>--}}
            <div class="form-group  @if($language == 'ar') rtl @endif">
                <label for="expiry_date" class=" @if($language == 'ar') rtl @endif">@lang('messages.expiry date')</label>
                <input type="date" name="expiry_date"  class="form-control @if($language == 'ar') rtl @endif" id="expiry_date" placeholder="enter phone">
            </div>

            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button>
        </form>

    <script>
        function generateCode(){
            var allCaracters = "123456789abcdefghijklmnopqrstuvwxyz";
            var charLen = allCaracters.length;
            var code = '' ;
            for( var i =0 ; i<6 ; i++){
                code += allCaracters.charAt(Math.floor(Math.random() * charLen));
            }
            document.getElementById("code").value=code;
        }
    </script>
@endsection
