@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
        if(isset($parent_cat_id)){
            $parent_id = $parent_cat_id;
        }else{
            $parent_id = 0;
        }
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.settings')</h2>
        </div>
    </div>
    <form method="post" action="{{route('settings.store')}}">
        @csrf
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" name="phone" class="form-control form-control-sm" id="colFormLabelSm" value="{{$settings->phone}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email"  name="email"  class="form-control" id="colFormLabel" value="{{$settings->email}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Facebook</label>
            <div class="col-sm-10">
                <input type="link"  name="facebook_url"  class="form-control form-control-lg" id="colFormLabelLg"value="{{$settings->facebook_url}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">twitter</label>
            <div class="col-sm-10">
                <input type="link"  name="twitter_url"  class="form-control form-control-lg" id="colFormLabelLg"value="{{$settings->twitter_url}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">instagram</label>
            <div class="col-sm-10">
                <input type="link"  name="instagram_url"  class="form-control form-control-lg" id="colFormLabelLg"value="{{$settings->instagram_url}}">
            </div>
        </div>
        <br>
        <input type="submit" class="btn btn-success">
    </form>
    <script>


    </script>
@endsection
