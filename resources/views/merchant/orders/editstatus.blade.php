@extends('merchant.layout')
@section('merchant-content')
    @php
        $language = App::getLocale();
    @endphp

    <div class="row  @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2><i class="fa fa-edit @if($language == 'ar') rtl @endif" style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i> &nbsp; @lang('messages.edit order status')</h2>
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
    <form method="post" action="{{url('merchant/control/orders/update_status/'.$order->id)}}"  enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif" style="width: 90%;border-top: 4px solid #007BFF;padding: 3%; margin: 2%;background: white;">
        {{ csrf_field() }}
        <div class="form-group @if($language == 'ar') rtl @endif">
            <label for="status">@lang('messages.status')</label>
            <select name="status" class="browser-default custom-select">

                <option value="1" @if($order->status == 1) selected @endif>review</option>
                <option value="2" @if($order->status == 2) selected @endif>preparation</option>
                <option value="3" @if($order->status == 3) selected @endif>delivery</option>
                <option value="4" @if($order->status == 4) selected @endif>delivered</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button>
    </form>
@endsection
