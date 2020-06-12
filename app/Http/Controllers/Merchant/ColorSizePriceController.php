<?php

namespace App\Http\Controllers\Merchant;

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
        $colors = Color::where('deleted_at',null)
            ->where('active',1)
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
//            ->where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->get();
        $color_products = ColorProduct::where('product_id',$request->product_id)
            ->where('deleted_at',null)
//            ->where('active',1)
            ->orderBy('order', 'asc')
            ->with('colors')
//            ->select('color_id','product_id', 'order')
//            ->groupBy('color_id')
            ->paginate(3);
//        dd($color_products);


//        dd($color_products);
        return view('merchant.color-size.create',[
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
        if($color_product){
            Session::flash('message', 'color_product activated successfully');

        }
        for ($size =0 ; $size < $countOfColorSizes ; $size++){
            $order = 'order_'.$size;
            $price = 'price_'.$size ;
            $quantity ='quantity_'.$size  ;
            $discount ='discount_'.$size  ;
            $size_id ='size_id_'.$size  ;
            if($request->$order != null && $request->$quantity != null && $request->$price != null && $request->$size_id != null && $request->$discount != null){
//                dd($request->$quantity);
                $request->validate([
                    $order => 'required|numeric',
                    $price => 'required|numeric',
                    $quantity => 'required|numeric',
                    $discount => 'required|numeric',
                ]);
                $insertColorSizeItem = DB::table('color_size')->insert([
                    'color_id' => $request->color,
                    'product_id' => $request->product_id,
                    'color_product' => $color_product,
                    'size_id' => $request->$size_id,
                    'price' => $request->$price,
                    'quantity' => $request->$quantity,
                    'discount' => $request->$discount,
                    'order' => $request->$order,
                    'created_at'=>Carbon::now()
                ]);
                if($insertColorSizeItem){
                    Session::flash('message', 'data saved successfully');

                }
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
        return Redirect::to('merchant/control/products/color-size/'.$product_id.'/'.$request->cat_id
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
        return view('merchant.color-size.sizes',[
            'colorProduct'=>$colorProduct,
            'coloSizes'=>$coloSizes,
            ]);
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
        return view('merchant.color-size.edit',[
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
        return view('merchant.color-size.edit',[
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
        return redirect('merchant/control/products/color-size/'.$request->product_id.'/'.$request->cat_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $colorProduct = DB::table('color_size')->where('id',$id)->first();
//        dd($colorProduct);
        $deleted = DB::table('color_size')->where('id',$id)->delete();
//        if(!$colorProduct){
//            return Redirect::back()->withErrors(['msg', 'data not found']);
//        }
//        $deleted = DB::table('color_product')->where('id',$id)->update([
//            'deleted_at'=>Carbon::now()
//        ]);
//        if(!$deleted){
//            return Redirect::back()->withErrors(['msg', 'data not found']);
//        }
        $deleteSizes = DB::table('color_size')->where('color_product',$id)->update([
            'deleted_at'=>Carbon::now()
        ]);
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'error deleting data']);
        }
        Session::flash('message', 'data deleted successfully');
        return Redirect::back();

    }
    public function activate ($id)
    {
        $colorProduct = DB::table('color_product')->where('id',$id)->first();
        if(!$colorProduct){
            return Redirect::back()->withErrors(['msg', 'data not found']);
        }
//        dd($colorProduct);
//        $updated = false;
        if($colorProduct->active == 0){
            $updated = DB::table('color_product')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'data activated successfully');
//            return Redirect::back();
        }else{
            $updated = DB::table('color_product')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'data deactivated successfully');
//            return Redirect::back();
        }


//        $updated =  DB::table('color_product')->where('id',$id)->update([
//            'active'=> 0,
//            'updated_at'=>Carbon::now()
//        ]);
//        if($updated == false){
//            return Redirect::back()->withErrors(['msg', 'deactivation failed']);
//        }
        $colorProduct = DB::table('color_product')->where('id',$id)->first();
        $colorSizes = ColorSize::where('color_product',$id)->get();
        foreach ($colorSizes as $colorSize){
            if($colorProduct->active == 0){
                $updated = $colorSize->update([
                    "active"=> 0
                ]);
                Session::flash('message', 'data deactivated successfully');
//            return Redirect::back();
            }else{
                $updated = $colorSize->update([
                    "active"=> 1
                ]);
                Session::flash('message', 'data activated successfully');
//            return Redirect::back();
            }

        }
//        update([
//            'active'=> 0,
//            'updated_at'=>Carbon::now()
//        ]);
        if(!$colorSizes){
            return Redirect::back()->withErrors(['deactivation failed']);
        }
        return Redirect::back();
    }
    public function editPriceAndQuantity($id){
        $colorSize = DB::table('color_size')->where('id',$id)->first();
//        dd($colorSize);
//        update([
//            "price"=>$request->price,
//            "quantity"=>$request->quantity,
//            "discount"=>$request->discount,
//            "updated_at"=>Carbon::now()
//        ]);
//        dd($colorSizes);
//        $data= DB::table('color_size')->where('id',$request->id)->first();
//        if($colorSizes){
//            return response()->json($data);
//        }
//        return response()->json('0');
return view('merchant.color-size.edit-size',[
    'colorSize'=>$colorSize,
    'product_id'=>$colorSize->product_id,
]);
    }
    public function updatePriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->colorSizeId)->first();
        $product = Product::find($request->product_id);
//        dd($product);
        $updated = DB::table('color_size')->where('id',$request->colorSizeId)->update([
            'quantity'=> $request->quantity,
            'price'=> $request->price,
            'order'=> $request->order,
            'discount'=> $request->discount,
        ]);
        if(!$updated){
            Session::flash('message', 'error updating data');
            return back();
        }
        Session::flash('message', 'data updated successfully');
        return \redirect('/merchant/control/products/color-size/'.$product->id.'/'.$product->cat_id);
    }

    public function deletePriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->id)->delete();
        if($colorSizes){
            return response()->json('1');
        }
        return response()->json('0');

    }
    public function deactivatePriceAndQuantity(Request $request){
        $colorSizes = DB::table('color_size')->where('id',$request->id)->first();
        if($colorSizes->active == 0){
            $updated = DB::table('color_size')->where('id',$request->id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'color_size updated successfully');
//            return Redirect::back();
        }else{
            $updated = DB::table('color_size')->where('id',$request->id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'color_size updated successfully');
//            return Redirect::back();
        }

//        "active"=>0,
//            "updated_at"=>Carbon::now()
//        ]);
        if($updated){
            return response()->json(DB::table('color_size')->where('id',$request->id)->first()->active);
        }
        return response()->json('0');

    }
}
