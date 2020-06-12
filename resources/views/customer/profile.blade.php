@extends('customer.layout')
@section('content')
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                <li class="active">@lang('messages.Profile')</li>
            </ul>
        </div>
    </div>

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <!-- section -->
    <div class="section login profile">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    @if($customer[0]->image_url != null)
                        <img src="{{asset('images/customers/'.$customer[0]->image_url)}}" alt="" class="img-responsive user">
                    @else
                        <img src="{{asset('img/user.png')}}" alt="" class="img-responsive user">
                    @endif

                        <a href="{{url('customer/profile')}}" class="btn btn-profile bg">@lang('messages.My info')</a>
                        <a href="{{url('customer/change_password')}}" class="btn btn-profile bg">@lang('messages.Change Password')</a>
                        <a href="{{url('customer/favourites')}}" class="btn btn-profile bg">@lang('messages.Favorite Items')</a>
                        <!-- <a href="prev-orders.php" class="btn btn-profile bg">My Prev Orders</a> -->
                        <a href="{{url('customer/orders')}}" class="btn btn-profile bg">@lang('messages.My Orders')</a>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title">
                                <h2 class="title">@lang('messages.My info')</h2>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{url('customer/edit_profile')}}">
                        @csrf
{{--                        <div class="form-group">--}}
{{--                            <label>Arabic Name:</label>--}}
{{--                            <input type="text" placeholder="" value="{{$customer[0]->arabic_name}}" class="input form-control">--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}
                        <input type="hidden" name="id" value="{{$customer[0]->id}}" class="input form-control">

                        <div class="form-group">
                            <label>@lang('messages.Name'):</label>
                            <input type="text" placeholder="" name="name" value="{{$customer[0]->name}}" class="input form-control">
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label>@lang('messages.Phone No'):</label>
                            <input type="text" placeholder="" name="phone" value="{{$customer[0]->phone}}" class="input form-control">
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <label>@lang('messages.E-mail'):</label>
                            <input type="text" placeholder="" name="email" value="{{$customer[0]->email}}" class="input form-control">
                            <div class="clearfix"></div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label>Username:</label>--}}
{{--                            <input type="text" placeholder="lamia magdy" class="input form-control">--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label>Password:</label>--}}
{{--                            <input type="text" placeholder="" class="input form-control">--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}

                        <button class="btn primary-btn">@lang('messages.Change')</button>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->


@endsection
