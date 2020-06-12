@include('customer.header')
@php
    $language = App::getLocale();
@endphp
@yield('content')
@include('customer.footer')
