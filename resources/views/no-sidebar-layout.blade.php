<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nazan Project</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{--    bootstrap--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .caret{
            display: none;
        }
        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .rtl {
            direction: rtl;
        }
        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>
<body class="hold-transition sidebar-mini">
@php
    $language = App::getLocale();
@endphp

<div class="wrapper" style="width: 85% @if($language == 'ar') position:inherit;@endif">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper table-hover" style="background: white; width: 90%; padding: 2%;@if($language == 'ar') margin-left: 0;@endif">
        @if (Auth::check())
            <li class="nav-item dropdown" style="list-style: none;">
                <a id="navbarDropdown" style="@if($language == 'ar')float: left;@else float: right;@endif" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"
                    >
                        @lang('messages.logout')
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown" style="list-style: none;">
                <a id="navbarDropdown" style="@if($language == 'ar')float: left;@else float: right;@endif" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @lang('messages.language') <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('/ar',['lang'=>'ar']) }}"
                        {{--                       onclick="event.preventDefault();--}}
                        {{--                     document.getElementById('lang-form').submit();"--}}
                    >
                        @lang('messages.arabic')
                    </a>
                    <a class="dropdown-item" href="{{ route('/en',['lang'=>'en']) }}"
                        {{--                       onclick="event.preventDefault();--}}
                        {{--                     document.getElementById('lang-form').submit();"--}}
                    >
                        @lang('messages.english')
                    </a>

                    {{--                    <form id="lang-form" action="" method="GET" style="display: none;">--}}
                    {{--                        @csrf--}}
                    {{--                    </form>--}}
                </div>
            </li>
        @endif
        @if (Route::has('login'))
            <div class="top-right links">
                <form class="form-group">
                    @auth
                        {{--                                    <a class="btn btn-dark" href="{{ url('/admin') }}">Home</a>--}}
                    @else
                        <a class="btn btn-default" href="{{ route('login') }}">@lang('messages.login')</a>

                        @if (Route::has('register'))
                            <a  class="btn btn-default"  href="{{ route('register') }}">@lang('messages.register')</a>
                        @endif
                    @endauth
                </form>

            </div>
        @endif

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @yield('content')

    <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{asset('dist/js/demo.js')}}"></script>
</body>
</html>
