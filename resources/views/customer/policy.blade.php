@extends('customer.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
            <li class="active">@lang('messages.policy')</li>
        </ul>
    </div>
</div>

<!-- section -->
<div class="section policy">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title">@lang('messages.policy')</h2>
                </div>
            </div>
            <div class="col-md-12">
                <p>
                    @if($language == 'en')
                        {{$policy->english_text}}
                    @elseif($language == 'ar')
                        {{$policy->arabic_text}}
                    @endif
                </p>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->
@endsection
