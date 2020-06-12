@extends('customer.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
            <li class="active">@lang('messages.about us')</li>
        </ul>
    </div>
</div>

<!-- section -->
<div class="section aboutus">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title">@lang('messages.about us')</h2>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <p>
                    @if($language == 'ar')
                        {{$about->arabic_text}}
                    @else
                        {{$about->english_text}}
                    @endif
                </p>
            </div>

            <div class="col-md-4 col-sm-12">
                <img src="{{asset('img/banner11.jpg')}}" alt="" class="img-responsive">
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->

@endsection
