@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col @if($language == 'ar') rtl @endif">
            <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.suggestions and complains')</h2>
        </div>
    </div>

    <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
        <thead>
        <tr class=" @if($language == 'ar') rtl @endif">
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.id')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.name')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.email')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.message')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.added date')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
        </tr>

        </thead>
        <tbody class=" @if($language == 'ar') rtl @endif">
        @foreach($messages as $message)
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif"> {{$message->id}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$message->category}}</th>
                <th class=" @if($language == 'ar') rtl @endif" > {{$message->name}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$message->email}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$message->message}}</th>
                <th class=" @if($language == 'ar') rtl @endif">{{$message->created_at}}</th>
                <th class=" @if($language == 'ar') rtl @endif">
                    <a href="{{url('suggestions/show/'.$message->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.show')</a>
                    <a href="{{url('suggestions/delete/'.$message->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}
@endsection
