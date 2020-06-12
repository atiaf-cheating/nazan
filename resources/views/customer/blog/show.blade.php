@extends('customer.layout')
@section('content')

    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li><a href="{{url('customer/blog')}}">blog</a></li>
                <li class="active">blog-details</li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section aboutus blog-details">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">{{$article->title}}</h2>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <p>
                        {{$article->body}}
                    </p>
                </div>

                <div class="col-md-4 col-sm-12">
                    <img src="{{asset('images/articles/'.$article->image_url)}}" alt="" class="img-responsive">
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
