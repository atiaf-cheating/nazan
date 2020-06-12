@extends('customer.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('/customer/home')}}">@lang('messages.Home')</a></li>
                <li><a href="{{url('customer/blog')}}">blog</a></li>
            </ul>
        </div>
    </div>

    <!-- section -->
    <div class="section aboutus blog">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">blog</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        @foreach($articles as $article)
                            <div class="info-det">
                                <div class="col-md-3">
                                    <img src="{{asset('images/articles/'.$article->image_url)}}" alt="" class="img-responsive">
                                </div>
                                <div class="col-md-9">
                                    <h3>{{$article->title}}</h3>
                                    <p>
                                        {{$article->body}}
                                    </p>
                                    <a href="{{url('customer/blog_details/'.$article->id)}}" class="more">@lang('messages.Read More')</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
