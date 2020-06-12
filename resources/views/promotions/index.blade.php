@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.promotions')</h2>
            </div>
            <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('promotions/create')}}"> @lang('messages.add new')</a>
            </div>

        </div>

        <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.product')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.days of expiry')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($promotions as $promotion)
                @if($promotion->product != null)

                    <tr class=" @if($language == 'ar') rtl @endif">
                        <th class=" @if($language == 'ar') rtl @endif">
                                {{$promotion->product['english_name']}}
                        </th>
                        <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">
                            <img src=" {{asset("images/promotions/".$promotion->image_url) }}" style="width: 100%;">
                        </th>
                        <th class=" @if($language == 'ar') rtl @endif" > {{$promotion->expiry_date}}</th>
                        <th class=" @if($language == 'ar') rtl @endif">
                            <a href="{{url('promotions/edit/'.$promotion->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                            <a href="{{url('promotions/activate/'.$promotion->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($promotion->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                            <a href="{{url('promotions/delete/'.$promotion->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                        </th>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        {{ $promotions->links() }}
@endsection
