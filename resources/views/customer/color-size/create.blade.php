@extends('no-sidebar-layout')
@section('content')
    @php
        $language = App::getLocale();
    @endphp
    <div class="row @if($language == 'ar') rtl @endif " style=" margin-top: 2%; margin-left: 2%;;padding:0;">
        <div class="col">
            <h2 style="color:#007BFF;">{{$product_name}}</h2>
            <h4><i class="fa fa-plus @if($language == 'ar') rtl @endif"
                                             style="background: #74777a;border-radius: 500%;font-size: 1.1rem;padding: 6px;color: #EEE;position: relative;top: -2px;"></i>
                &nbsp;@lang('messages.create new color/size')
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
    <form method="post" action="{{route('product_color_size.store')}}" id="color_size_form" enctype="multipart/form-data" class=" @if($language == 'ar') rtl @endif"
          style="width: 90%;border-top: 4px solid #007BFF;border-bottom: 4px solid #007BFF; padding: 3%; margin: 2%;background: white;">
        {{ csrf_field() }}
        <input name="product_id" value="{{$product_id}}" hidden>
        <input name="number_of_sizes" value="{{count($sizes)}}" hidden>
        <input name="cat_id" value="{{$cat_id}}" hidden>
        <div class="form-group row  @if($language == 'ar') rtl @endif">
            <div class="col-md-7">
                <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.select color')</label>
                <select  name="color" class="browser-default custom-select">
                    @foreach($colors as $color)
                        <option value="{{$color->id}}">{{$color->arabic_name .'-'. $color->english_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label for="parent_cat" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
                <input id="size_input" name="color_order" class="form-control" type="text" class="" value="">
            </div>
        </div>
        <hr>
        @foreach($sizes as $key => $size)
            <div class="row">
                <div class="form-group col-md-4 form-inline @if($language == 'ar') rtl @endif">
                    <input id="size_input" name="size_id_{{$key}}" type="checkbox" class="" value="{{$size->id}}">
                    <label for="size_input" class=" @if($language == 'ar') rtl @endif">{{$size->arabic_name .'-'. $size->english_name}}</label>
                </div>
                <div class="form-inline col-md-8">
                    <div class="form-group   @if($language == 'ar') rtl @endif">
                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</label>
                        <input type="text" name="price_{{$key}}">
                    </div>
                    <div class="form-group  @if($language == 'ar') rtl @endif">
                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</label>
                        <input type="text" name="order_{{$key}}">
                    </div>
                    <div class="form-group  @if($language == 'ar') rtl @endif">
                        <label for="size_input" class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</label>
                        <input type="text" name="quantity_{{$key}}">
                    </div>
                </div>
            </div>
            <br><hr>
        @endforeach
        <button type="submit" class="btn btn-primary @if($language == 'ar') rtl @endif" style="float:right;">@lang('messages.add')</button><br>
    </form>
{{--@php dd($color_products); @endphp--}}
    <table class="table table-bordered products-table @if($language == 'ar') rtl @endif" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">
        <thead class="thead-light">
        <tr class=" @if($language == 'ar') rtl @endif">
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.color')</th>
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.size')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.price')</th>--}}
{{--            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.quantity')</th>--}}
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.order')</th>
            <th class=" @if($language == 'ar') rtl @endif">@lang('messages.actions')</th>
        </tr>
        </thead>
        <tbody class=" @if($language == 'ar') rtl @endif">
        @foreach($color_products as $key => $color_product)
            <tr id="{{$key}}" class=" @if($language == 'ar') rtl @endif">
                <th class=" @if($language == 'ar') rtl @endif"> {{$color_product->colors->arabic_name .'-'.$color_product->colors->english_name}}</th>
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$color_size->size_id}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$color_size->price}}</th>--}}
{{--                <th class=" @if($language == 'ar') rtl @endif">{{$color_size->quantity}}</th>--}}
                <th class=" @if($language == 'ar') rtl @endif">{{$color_product->order}}</th>
                <th class=" @if($language == 'ar') rtl @endif">
                    <a href="{{url('color_size/edit/'.$product_id.'/'.$color_product->id.'/'.$cat_id)}}" class="btn btn-info @if($language == 'ar') rtl @endif">@lang('messages.edit')</a>
                    <a href="{{url('color_size/activate/'.$color_product->id)}}" class="btn btn-warning @if($language == 'ar') rtl @endif">@if($color_product->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</a>
                    <a href="{{url('color_size/delete/'.$color_product->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger @if($language == 'ar') rtl @endif">@lang('messages.delete')</a>
                    <button href="#" data-id="{{$color_product->id}}" id="sizes_{{$key}}" data_key="{{$key}}" onclick="showSizes({{$key}})" class="btn btn-success @if($language == 'ar') rtl @endif">@lang('messages.sizes')</button>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $color_products->links() }}

    <script>
        function showSizes(key) {
            if($('.sizesDetailedTable_'+key).length === 0){
                $id = $("#sizes_"+key).attr("data-id");
                // $trNumber = $(this).attr("data-key");
                console.log($id);
                $.ajax({
                    method: "get",
                    url: "/color_size/sizes/" + $id,
                    data: {
                        id: $id,
                        "_token": "{{ csrf_token() }}"
                    }
                }).done(function ($data) {
                    console.log($data);
                    if (Object.keys($data).length !== 0) {
                        $sizesTable = `<table class="table table-bordered sizesDetailedTable_${key}" style=" margin-top: 2%; margin-left: 2%;width:90%;" id="table">` +
                            `<thead class="thead-light">` +
                            `<tr><th>@lang('messages.size')</th>
                                    <th>@lang('messages.price')</th>
                                    <th>@lang('messages.quantity')</th>
                                    <th>@lang('messages.order')</th>
                                    <th>@lang('messages.actions')</th>
                        </tr> </thead> <tbody class="sizes_tbody">`;

                        $("#" + key).after($sizesTable);

                        $.each($data, function (sizes_key, value) {
                            console.log(value);
                            $tbodyData = ` <tr id="detailsRow_${sizes_key}"><th>${value.sizes.arabic_name}-${value.sizes.english_name}</th>
                                            <th class="priceBox_${sizes_key}">${value.price}</th>
                                            <th class="quantityBox_${sizes_key}">${value.quantity}</th>
                                            <th>${value['order']}</th>
                                            <th>
                                                <button data-sizeId="${value.size_id}" data-price="${value.price}" data-quantity="${value.quantity}"  onclick="editSizeFunction(${sizes_key},${value.id},${value.size_id},${value.price},${value.quantity})" id="edit_size_${sizes_key}" data-color-size-id="${value.id}" class="btn btn-info">@lang('messages.edit')</button>
                                                <button onclick="deactivateSizeFunction(${sizes_key},${value.id})" id="deactivate_size_${sizes_key}" data-color-size-id="${value.id}" class="btn btn-warning ">@if($promotion->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif@if($promotion->active == 0) @lang('messages.activate') @else @lang('messages.deactivate') @endif</button>
                                                <button onclick="return confirm('Are you sure?')" onclick="deleteSizeFunction(${sizes_key},${value.id})" id="delete_size_${sizes_key}" data-color-size-id="${value.id}" class="btn btn-danger ">@lang('messages.delete')</button>
                                            </th>
                                        </tr>`;
                            // $option = `<option class="sub_cat_option" value="${value.id}">${value.arabic_name} - ${value.english_name}</option>`;
                            $(".sizesDetailedTable_"+key).children('.sizes_tbody').append($tbodyData);

                            console.log(key + ": " + value.arabic_name);



                        });
                        // $closingTable = "</tbody></table>"
                        // $(".sizesDetailedTable_" + key).after($sizesTable);

                        // $("#cat_id_"+subCat_1 + " .sub_cat_option:last-child").after('</select></div>');
                        // $(".sub_cat_option").
                    }
                }).fail(function () {
                    alert("error");
                })
            }else {
                $('.sizesDetailedTable_'+key).css('display','none');
            }
        }
        function editSizeFunction( btnKey , color_size_id , sizeId ,price ,quantity) {
            $editRow = `<br> <div class="row">&nbsp;&nbsp;&nbsp;
                    <label for="size_input" class="col ">size : ${sizeId}</label>&nbsp;
                        <label for="size_input" class="col">@lang('messages.price')</label>&nbsp;
                        <input id="newPrice_${btnKey}" type="text"  class="col form-control" value="${price}">&nbsp;
                        <label  for="size_input" class="col ">@lang('messages.quantity')</label>&nbsp;
                        <input id="newQuantity_${btnKey}" type="text"  class="col form-control" value="${quantity}">&nbsp;
                        <button  class="btn btn-success col" onclick="storeSizeDataFunction(${btnKey},${color_size_id},${price},${quantity})" value="">save</button>
            </div>`;
            $("#detailsRow_"+btnKey).after($editRow);
        }
        function storeSizeDataFunction(btnKey ,color_size_id,price,quantity) {
            console.log('kkkk');
            $.ajax({
                method: "post",
                url: "/color_size/edit-price-quantity",
                data: {
                    "id": color_size_id,
                    "price": $("#newPrice_"+btnKey).val(),
                    "quantity": $("#newQuantity_"+btnKey).val(),
                    "_token": "{{ csrf_token() }}"
                }
            }).done(function ($data) {
                console.log($data);
                $(".priceBox_"+btnKey).html($data.price);
                $(".quantityBox_"+btnKey).html($data.quantity);
            }).fail(function () {
                alert("error");
            })
        }
        function deactivateSizeFunction(btnKey , color_size_id) {
            console.log('uuuuuuuuuuu');
            $.ajax({
                method: "post",
                url: "/color_size/deactivate-price-quantity",
                data: {
                    "id": color_size_id,
                    "_token": "{{ csrf_token() }}"
                }
            }).done(function ($data) {
                console.log($data);
                $("#detailsRow_"+btnKey).css('display','none');
            }).fail(function () {
                alert("error");
            })
        }
        function deleteSizeFunction(btnKey , color_size_id) {
            console.log('yyyyyyyyyyyyy');
            $.ajax({
                method: "post",
                url: "/color_size/delete-price-quantity",
                data: {
                    "id": color_size_id,
                    "_token": "{{ csrf_token() }}"
                }
            }).done(function ($data) {
                console.log($data);
                $("#detailsRow_"+btnKey).css('display','none');
            }).fail(function () {
                alert("error");
            })
        }
    </script>
@endsection
