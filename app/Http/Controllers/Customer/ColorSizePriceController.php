<?php

namespace App\Http\Controllers;

use App\Color;
use App\ColorProduct;
use App\ColorSize;
use App\Product;
use App\Size;
use Carbon\Carbon;
use foo\bar;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ColorSizePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        dd($request);
        $product = Product::findOrFail($request->product_id);
        $colors = Color::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $sizes = Size::where('active',1)
            ->where('deleted_at',null)
            ->where('cat_id',$request->cat_id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $color_sizes = DB::table('color_size')
            ->where('product_id',$request->product_id)
            ->where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->get();
        $color_products = ColorProduct::where('product_id',$request->product_id)
            ->where('deleted_at',null)
            ->where('active',1)
            ->orderBy('order', 'asc')
            ->with('colors')
//            ->select('color_id','product_id', 'order')
//            ->groupBy('color_id')
            ->paginate(3);
//        dd($color_products);


//        dd($color_products);
        return view('color-size.create',[
            "colors"=>$colors,
            "sizes"=>$sizes,
            "cat_id"=>$request->cat_id,
            "colors_sizes"=>$color_sizes,
            "color_products"=>$color_products,
            "product_id"=>$request->product_id,
            "product_name"=>$product->english_name.'-'.$product->arabic_name,
        ]);
    }
    public function store(Request $request)
    {
//        dd($request);
        $product_id = $request->product_id;
        $request->validate([
            'color' => 'required|numeric',
            'product_id' => 'required|numeric',
            'color_order' => 'required|numeric',
        ]);
        $countOfColorSizes = $request->number_of_sizes;
        $ColorProductItem =  DB::table('color_product')->where([
            'color_id' => $request->color,
            'product_id' => $request->product_id,
            'order' => $request->color_order
        ])->first();
        if(!$ColorProductItem){
            $insertColorProductItem = DB::table('color_product')->insertGetId([
                'color_id' => $request->color,
                'product_id' => $request->product_id,
                'order' => $request->color_order,
                'created_at'=>Carbon::now()
            ]);
            $color_product = $insertColorProductItem;
        }else{
            $color_product = $ColorProductItem->id;
        }
        for ($size =0 ; $size < $countOfColorSizes ; $size++){
            $order = 'order_'.$size;
            $price = 'price_'.$size ;
            $quantity ='quantity_'.$size  ;
            $size_id ='size_id_'.$size  ;
            if($request->$order != null && $request->$quantity != null && $request->$price != null && $request->$size_id != null){
//                dd($request->$quantity);
                $request->validate([
                    $order => 'required|numeric',
                    $price => 'required|numeric',
                    $quantity => 'required|numeric',
                ]);
                $insertColorSizeItem = DB::table('color_size')->insert([
                    'color_id' => $request->color,
                    'product_id' => $request->product_id,
                    'color_product' => $color_product,
                    'size_id' => $request->$size_id,
                    'price' => $request->$price,
                    'quantity' => $request->$quantity,
                    'order' => $request->$order,
                    'created_at'=>Carbon::now()
                ]);
//                dd($insertColorSizeItem);
            }
        }

        $colors = Color::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $sizes = Size::where('active',1)
            ->where('deleted_at',null)
            ->where('cat_id',$request->cat_id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
//        dd($request->cat_id);
        $color_sizes = DB::table('color_size')->where('product_id',$request->product_id)->get();
        return Redirect::to('/products/color-size/'.$product_id.'/'.$request->cat_id
//            ,[
//            "colors"=>$colors,
//            "sizes"=>$sizes,
//            "colors_sizes"=>$color_sizes,
////            "product_id"=>$product_id,
//        ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showSizes($id)
    {
        $colorProduct= ColorProduct::where('id',$id)->with('colors')->first();
        $coloSizes =  ColorSize::where('color_product',$colorProduct->id)->with('sizes')->get();
//        dd($coloSizes);
        return response()->json($coloSizes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $colorProduct = ColorProduct::where('id',$request->color_product)->with('colors')->first();
        $colors = Color::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        return view('color-size.edit',[
            "colors"=>$colors,
//            "size"=>$size,
            "cat_id"=>$request->cat_id,
            "colorProduct"=>$colorProduct,
            "product_id"=>$request->product_id,
            "product_name"=>$product->english_name.'-'.$product->arabic_name,
        ]);


        if(!$colorSize){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        return view('color-size.edit',[
            'colorSize'=>$colorSize
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $colorProduct =  DB::table('color_product')->where('id',$request->color_product)->first();
        if(!$colorProduct){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        $updated =  DB::table('color_product')->where('id',$request->color_product)->update([
            'order' => $request->color_order,
            'updated_at'=>Carbon::now()
        ]);
        if(!$updated){
            return Redirect::back()->withErrors(['msg', 'update failed']);
        }
        return \redirect('/products/color-size/'.$request->product_id.'/'.$request->cat_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colorProduct = DB::table('color_product')->where('id',$id)->first();
        if(!$colorProduct){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        $deleted = DB::table('color_product')->where('id',$id)->update([
            'deleted_at'=>Carbon::now()
        ]);
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        $deleteSizes = DB::table('color_size')->where('color_product',$id)->update([
            'deleted_at'=>Carbon::now()
        ]);
        if(!$deleteSizes){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        return Redirect::back();

    }
    public function activate ($id)
    {
        $colorProduct = DB::table('color_product')->where('id',$id)->first();
        if(!$colorProduct){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
        $updated =  DB::table('color_product')->where('id',$id)->update([
            'active'=> 0,
            'updated_at'=>Carbon::now()
        ]);
        if(!$updated){
            return Redirect::back()->withErrors(['msg', 'deactivation failed']);
        }
        $colorSizes = DB::table('color_size')->where('color_product',$id)->update([
            'active'=> 0,
            'updated_at'=>Carbon::now()
        ]);
        if(!$colorSizes){
            return Redirect::back()->withErrors(['deactivation failed']);
        }
        return Redirect::back();
    }
    public function editPriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->id)->update([
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "updated_at"=>Carbon::now()
        ]);
        $data= DB::table('color_size')->where('id',$request->id)->first();
        if($colorSizes){
            return response()->json($data);
        }
        return response()->json('0');

    }
    public function deletePriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->id)->update([
            "deleted_at"=>Carbon::now()
        ]);
        if($colorSizes){
            return response()->json('1');
        }
        return response()->json('0');

    }
    public function deactivatePriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->id)->update([
            "active"=>0,
            "updated_at"=>Carbon::now()
        ]);
        if($colorSizes){
            return response()->json(1);
        }
        return response()->json('0');

    }
}
