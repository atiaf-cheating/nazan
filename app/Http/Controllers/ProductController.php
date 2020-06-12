<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Color;
use App\Merchant;
use App\Product;
use App\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $cat_id = 0)
    {
        if(session()->has('merchant_id')){
            $merchant = Merchant::find(session()->get('merchant_id'));
            $allProducts = Product::where('deleted_at',null)
//                -where('active',1)
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->where('merchant_id',session()->get('merchant_id'))
//                ->with('merchant')
                ->with('brand')
                ->with('category')
//            ->join('merchants','products.merchant_id','=','merchants.id')
                ->paginate(8);
            foreach ($allProducts as $product){
                $product['merchant'] = $merchant;
            }
        }else{
            $allProducts = Product::where('deleted_at',null)
//                ->where('active',1)
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->with('merchant')
                ->with('brand')
                ->with('category')
//            ->join('merchants','products.merchant_id','=','merchants.id')
                ->paginate(8);
        }

        if(!$allProducts){
            return view('products.index',['products'=>[]]);
        }

        return view('products.index',[ 'products'=>$allProducts]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cat_id = 0)
    {
        $merchants = Merchant::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $brands = Brand::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $colors = Color::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $sizes= Size::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $categories= Category::where('active',1)
            ->where('deleted_at',null)
            ->where('parent_cat_id',0)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
//        dd($sizes);
        return view('products.create',[
            'merchants'=>$merchants
            ,'colors'=>$colors
            ,'sizes'=>$sizes
            ,'categories'=>$categories
            ,'brands'=>$brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'description' => 'required',
//            'cat_id' => 'required|numeric',
            'final_sub_cat' => 'required|numeric',
            'merchant_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        $image = $request->file('image_url');
        $uniqueName = time().'.'.$image->extension();

        $destinationPath = public_path('images/products');

        $image->move($destinationPath, $uniqueName);
        $product= Product::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'description' => $request->description,
            'order' => $request->order,
            'cat_id' => $request->final_sub_cat,
            'merchant_id' => $request->merchant_id,
            'brand_id' => $request->brand_id,
            'image_url' => $uniqueName ,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);
        $arr = [];
//        dd($request->filename);
        if($request->has('filename')){
            $request->validate([
                'filename'=> 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
            ]);
            foreach($request->file('filename') as $image)
            {
//                array_push($arr,$image);
                $uniqueName = time().$image->getClientOriginalName();
                $destinationPath = public_path('images/products');
                $image->move($destinationPath, $uniqueName);

                $insertAttachments = DB::table('product_attachments')->insert([
                   'product_id'=>$product->id,
                   'attachment_url'=>$uniqueName,
                   'created_at'=>Carbon::now(),
                ]);
            }
//            dd($arr);
        }
        if(!$product){
            Session::flash('message', 'failed to create product');
            return redirect('/products/');
        }
        Session::flash('message', 'product created successfully');
        return redirect('/products/');

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $merchants = Merchant::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $brands = Brand::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        return view('products.edit',[
            "product"=>$product,
            "merchants"=>$merchants,
            "brands"=>$brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request);
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'merchant_id' => 'required|numeric',
        ]);
        $product =Product::findOrFail($id);
        $updated = $product->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'description' => $request->description,
            'order' => $request->order,
            'cat_id' => $request->cat_id,
            'brand_id' => $request->brand_id,
            'merchant_id' => $request->merchant_id,
            'updated_at' => Carbon::now()
        ]);
        if($request->has('image_url')){
            $image = $request->file('image_url');
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/products');

            $image->move($destinationPath, $uniqueName);

            $product->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update product');
            return redirect('/products/');
        }
        Session::flash('message', 'product updated successfully');
        return redirect('/products/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $deleted = $product->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete product']);
        }
        Session::flash('message', 'product deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        if($product->active == 0){
            $updateCustomer = DB::table('products')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'product activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('products')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'product deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate product');
            return redirect('/products');

    }
}
