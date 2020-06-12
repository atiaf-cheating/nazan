@extends('merchant.no-sidebar-layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col">
            {{--            <h2 style="color:#007BFF;">{{$product_name}}</h2>--}}
            <h4><i class="fa fa-plus @if($language == 'ar') rtl @endif"
                   style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i>
                &nbsp;@lang('messages.edit color/size')
            </h4>
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
        <form method="post" action="{{url('/merchant/control/color_size/update-price-quantity')}}" id="color_size_form" enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif"
              style="width: 90%;border-top: 4px solid #007BFF;border-bottom: 4px solid #007BFF; padding: 3%; margin: 2%;background: white;">
            {{ csrf_field() }}
            <input name="colorSizeId" value="{{$colorSize->id}}" hidden>
            <input name="product_id" value="{{$product_id}}" hidden>
            <input name="colorSizeId" value="{{$colorSize->id}}" hidden>
            <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</label>

            <input name="quantity" class="form-control" value="{{$colorSize->quantity}}" >
            <br>
            <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</label>

            <input name="price" class="form-control" value="{{$colorSize->price}}" >
            <br>
            <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>

            <input name="order" class="form-control" value="{{$colorSize->order}}" >
            <br>
            <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.discount')</label>

            <input name="discount" class="form-control" value="{{$colorSize->discount}}" >
            <br>
{{--            <input name="number_of_sizes" value="{{count($sizes)}}" hidden>--}}
{{--            <input name="cat_id" value="{{$cat_id}}" hidden>--}}
{{--            <div class="form-group row  @if($language == 'ar') rtl @endif">--}}
{{--                <div class="col-md-7">--}}
{{--                    <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.select color')</label>--}}
{{--                    <select  name="color" class="browser-default custom-select">--}}
{{--                        @foreach($colors as $color)--}}
{{--                            <option value="{{$color->id}}">{{$color->arabic_name .'-'. $color->english_name}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-md-5">--}}
{{--                    <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>--}}
{{--                    <input id="size_input" name="color_order" class="form-control" type="text" class="" value="">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <hr>--}}
{{--            @foreach($sizes as $key => $size)--}}
{{--                <div class="row">--}}
{{--                    <div class="form-group col-md-4 form-inline @if($language == 'ar') rtl @endif">--}}
{{--                        <input id="size_input" name="size_id_{{$key}}" type="checkbox" class="" value="{{$size->id}}">--}}
{{--                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">{{$size->arabic_name .'-'. $size->english_name}}</label>--}}
{{--                    </div>--}}
{{--                    <div class="form-inline col-md-8">--}}
{{--                        <div class="form-group   @if($language == 'ar') rtl @endif">--}}
{{--                            <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</label>--}}
{{--                            <input type="text" name="price_{{$key}}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                            <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>--}}
{{--                            <input type="text" name="order_{{$key}}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                            <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</label>--}}
{{--                            <input type="text" name="quantity_{{$key}}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group  @if($language == 'ar') rtl @endif">--}}
{{--                            <label for="discount_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.discount')</label>--}}
{{--                            <input type="text" name="discount_{{$key}}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br><hr>--}}
{{--            @endforeach--}}
            <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.save')</button><br>
        </form>
{{--    <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">--}}
{{--        <thead class="thead-light">--}}
{{--        <tr class=" @if($language == 'ar') rtl @endif">--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.color')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.discount')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody class=" @if($language == 'ar') rtl @endif">--}}
{{--        @foreach($coloSizes as $key => $colorSize)--}}
{{--            --}}{{--                        @php dd($colorSize) @endphp--}}
{{--            <tr id="{{$key}}" class=" @if($language == 'ar') rtl @endif">--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">--}}
{{--                    {{$colorSize->sizes->arabic_name .'-'.$colorSize->sizes->english_name}}--}}
{{--                </th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$colorSize->quantity}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$colorSize->price}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$colorSize->discount}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$colorSize->order}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">--}}
{{--                    <a href="{{url('merchant/control/color_size/edit-price-quantity/'.$colorSize->id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>--}}
{{--                    --}}{{--                    <a href="{{url('merchant/control/color_size/activate/'.$color_product->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($color_product->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>--}}
{{--                    <a href="{{url('merchant/control/color_size/delete/'.$colorSize->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>--}}
{{--                    --}}{{--                    <a href="{{url('merchant/control/color_size/sizes/'.$color_product->id)}}"--}}
{{--                    --}}{{--                                                        data-id="{{$color_product->id}}" id="sizes_{{$key}}" data_key="{{$key}}" onclick="showSizes({{$key}})"--}}
{{--                    --}}{{--                            class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.sizes')</a>--}}
{{--                </th>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
    {{--    {{ $coloSizes->links() }}--}}

@endsection
