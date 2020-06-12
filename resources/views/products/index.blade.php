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
                <h2 class=" @if($language == 'ar') rtl @endif">@lang('messages.products')</h2>
            </div>
{{--            @if(count($products) == 0)--}}
                <div class="col  @if($language == 'ar') rtl @endif" style="float:right;padding:0;">
                    <a class="btn btn-success @if($language == 'ar') rtl @endif" href="{{url('products/create/')}}"> @lang('messages.add new')</a>
                </div>
{{--            @endif--}}

        </div>

        <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
            <thead>
            <tr class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.arabic name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.english name')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.description')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.merchant')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.brand')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.category')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.photo')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
                <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
            </tr>

            </thead>
            <tbody class=" @if($language == 'ar') rtl @endif">
            @if(count($products) == 0)
            @endif
            @foreach($products as $product)
{{--@php                dd($product->category)@endphp--}}

                <tr class=" @if($language == 'ar') rtl @endif">
                    <th class=" @if($language == 'ar') rtl @endif"> {{$product->arabic_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->description}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->merchant->arabic_name .'-'.$product->merchant->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->brand->arabic_name .'-'.$product->brand->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->category->arabic_name .'-'.$product->category->english_name}}</th>
                    <th class=" @if($language == 'ar') rtl @endif" style="width: 6%; height: 6%;">
                        <img src=" {{asset("images/products/".$product->image_url) }}" style="width: 100%;">
                    </th>
                    <th class=" @if($language == 'ar') rtl @endif">{{$product->order}}</th>
                    <th class=" @if($language == 'ar') rtl @endif">


                        <a id="colors_sizes_btn" onclick="window.open(document.URL+ '/color-size/' + {{$product->id}}+ '/'+{{$product->cat_id}}, '_blank',
                            'location=yes,top=50,left=200,height=900,width=1500,scrollbars=yes,status=yes');"
                           class="btn btn-success @if($language == 'ar') rtl @endif" style="color:white;">@lang('messages.add color/size details')</a>
                        <a href="{{url('products/edit/'.$product->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                        <a href="{{url('products/activate/'.$product->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($product->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                        <a href="{{url('products/delete/'.$product->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    <script>
        document.getElementById("colors_sizes_btn").addEventListener("click", function(event){
            event.preventDefault();
        });
    </script>
@endsection
