@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.articles')</h2>
            </div>
            <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('articles/create')}}"> @lang('messages.add new')</a>
            </div>

        </div>

        <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.title')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.body')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @foreach($articles as $article)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$article->title}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$article->body}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$article->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">
                        <img src=" {{URL::asset("images/articles/".$article->image_url) }}" style="width: 100%;"><br><br>
                    </th>
                    <th class=" @if($language == 'ar') rtl @endif">
                        <a href="{{url('articles/edit/'.$article->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                        <a href="{{url('articles/activate/'.$article->id)}}"  onclick="return confirm('Are you sure?')"  class="btn btn-warning @if($language == 'ar') rtl @endif">@if($article->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                        <a href="{{url('articles/delete/'.$article->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $articles->links() }}
@endsection
