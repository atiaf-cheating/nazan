@extends('categories.layout')
@section('head')
    @trixassets
@endsection
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col  @if($language == 'ar') rtl @endif">
            <h2><i class="fa fa-plus @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp;@lang('messages.terms of services')</h2>
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
    <form method="post" action="{{route('usagepolicy.store')}}">
        @csrf
        <input value="{{$usagepolicy->english_text}}" id="eng" hidden>
        <input value="{{$usagepolicy->arabic_text}}" id="ar" hidden>

        <div id="eng_text">
            {!! $usagepolicy->trix('english_text') !!}
        </div>

        <h3>enter arabic text</h3>
        <div id="ar_text">
            {!! $usagepolicy->trix('arabic_text') !!}
        </div>

{{--        <h3>enter english text</h3>--}}
{{--        {!! $usagepolicy->trix('english_text') !!}--}}

{{--        <h3>enter arabic text</h3>--}}
{{--        {!! $usagepolicy->trix('arabic_text') !!}--}}
        <input type="submit">
    </form>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $englishContent = $('#eng').val();
            console.log($englishContent);
            $arabicContent = $('#ar').val();
            $("#eng_text span trix-editor").html($englishContent);
            $("#ar_text span trix-editor").html($arabicContent);
        });
    </script>
@endsection
