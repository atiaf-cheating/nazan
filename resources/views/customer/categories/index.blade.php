@extends('categories.layout')
@section('content')
    @php
        $language = App::getLocale();
        if(isset($parent_cat_id)){
            $parent_id = $parent_cat_id;
        }else{
            $parent_id = 0;
        }
    @endphp
        <div class="row @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;;padding:0;">
            <div class="col @if($language == 'ar') rtl @endif">
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.categories')</h2>
            </div>
                <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                    <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('categories/create/'.$parent_id)}}"> @lang('messages.add new')</a>
                </div>

        </div>

        <table class="table table-bordered categories-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @if(count($categories) == 0)
            @endif
            @foreach($categories as $category)
                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$category->arabic_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$category->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">
                        <img src=" {{asset("images/categories/".$category->image_url) }}" style="width: 100%;">
                    </th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$category->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">
                        <a href="{{url('/categories/'.$category->id)}}" class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.sub categories')</a>
                        <a href="{{url('categories/edit/'.$category->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                        <a href="{{url('categories/activate/'.$category->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($category->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                        <a href="{{url('categories/delete/'.$category->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                        <a href="{{url('categories/create/'.$category->id)}}" class="btn btn-dark @if($language == 'ar') rtl @endif">@lang('messages.add sub category')</a>
                        <a id="sizes_btn" onclick="window.open(document.URL.substring(0, document.URL.indexOf('categories'))+ 'sizes/' + {{$category->id}}, '_blank',
                            'location=yes,top=50,left=200,height=850,width=1500,scrollbars=yes,status=yes');"
                            class="btn btn-primary @if($language == 'ar') rtl @endif">@lang('messages.sizes')</a>

                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    <script>
        document.getElementById("sizes_btn").addEventListener("click", function(event){
            event.preventDefault();
        });
        document.getElementById("sizes_btn").addEventListener("click", function(event){
            event.preventDefault();
        });
    </script>
@endsection
