@extends('categories.layout')
@section('content')
@if (Route::has('login'))
    <div class="top-right links">
        <form class="form-group rtl">
            @auth

                <a class="btn btn-dark rtl" href="{{ url('/admin') }}">@lang('messages.Home')</a>
            @else
                <a class="btn btn-default rtl" href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a  class="btn btn-default rtl"  href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </form>

    </div>
@endif
@endsection
