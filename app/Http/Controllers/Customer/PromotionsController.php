<?php

namespace App\Http\Controllers\Customer;

use App\Brand;
use App\Color;
use App\ColorSize;
use App\Favourites;
use App\Product;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($brand_id = null)
    {
//        dd($brand_id);
        $promotions = Promotion::where('expiry_date','>=',Carbon::now())
            ->where('deleted_at',null)
            ->where('active',1)
            ->get();
//        dd($promotions->pluck('product_id')->unique());
        $favourites =new Collection();
        if(Session::has('customer')){
            $favourites = Favourites::where('user_id',Session::get('customer')->id)->where('deleted_at',null)->get()->pluck('product_id')->unique();
        }
        if($brand_id != null){
            $allProducts= Product::where('active',1)
                ->where('deleted_at',null)
                ->where('brand_id',$brand_id)
                ->whereIn('id',$promotions->pluck('product_id')->unique())
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->orderBy('created_at','DESC')
                ->with('category')
                ->with('brand')
                ->paginate(8);
        }else {
            $allProducts = Product::where('active', 1)
                ->where('deleted_at', $brand_id)
                ->whereIn('id', $promotions->pluck('product_id')->unique())
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->orderBy('created_at', 'DESC')
                ->with('category')
                ->with('brand')
                ->paginate(8);
        }
//        dd($allProducts);
        foreach ($allProducts as $product){
            $allProductColors = DB::table('color_product')
                ->where('product_id',$product->id)
                ->where('active',1)
                ->where('deleted_at',null)
                ->get()->pluck('color_id')->unique();
            $allColors = Color::whereIn('id',$allProductColors)
                ->where('active',1)
                ->where('deleted_at',null)
                ->orderBy('order', 'asc')
//                ->with('sizes.sizes')
                ->get();
            foreach ($allColors as $color){
                $sizes = ColorSize::where('color_id',$color->id)
                    ->where('product_id',$product->id)
                    ->get();
                $color['sizes']=$sizes;
            }
            $product['colors']=$allColors;
//                dd($favourites);
            if(in_array($product->id,$favourites->toArray())){
                $product['is_favourite']=true;
            }else{
                $product['is_favourite']=false;
            }
        }
//        dd($allProducts);

        if(!$allProducts){
            return view('customer.promotions.index',[
                'promotions'=>[],
            ]);
        }

        return view('customer.promotions.index',[
            'promotions'=>$allProducts,
        ]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allProducts = Product::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        if(!$allProducts){
            return view('promotions.create',['products'=>[]]);
        }
        return view('promotions.create',[ 'products'=>$allProducts]);
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
            'product_id' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'expiry_date' => 'required',
        ]);
        $image = $request->image_url;
        $uniqueName = time().'.'.$image->extension();
        $destinationPath = public_path('images/promotions');
        $image->move($destinationPath, $uniqueName);

        $Promotion = Promotion::create([
            'product_id' => $request->product_id,
            'expiry_date' => $request->expiry_date,
            'image_url' => $uniqueName,
            'created_at' => Carbon::now()
        ]);


        if(!$Promotion){
            Session::flash('message', 'failed to create Promotion');
            return redirect('/promotions/');
        }
        Session::flash('message', 'Promotion created successfully');
        return redirect('/promotions/');

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
        $allProducts = Product::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $promotion = Promotion::where('id',$id)->with('product')->first();
        return view('promotions.edit',[
            "promotion"=>$promotion,
            "products"=>$allProducts,
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
//        dd($request->all());
        $request->validate([
            'product_id' => 'required',
//            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'expiry_date' => 'required',
        ]);
        $Promotion = Promotion::where('id',$id)->update([
            'product_id' => $request->product_id,
            'expiry_date' => $request->expiry_date,
            'created_at' => Carbon::now()
        ]);
        if($request->has('image_url')){
            $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $image = $request->image_url;
            $uniqueName = time().'.'.$image->extension();
            $destinationPath = public_path('images/promotions');
            $image->move($destinationPath, $uniqueName);
            $Promotion = Promotion::where('id',$id)->update([
                'image_url' => $uniqueName,
            ]);
        }
        if(!$Promotion){
            Session::flash('message', 'failed to update Promotion');
            return redirect('/promotions/');
        }
        Session::flash('message', 'Promotion updated successfully');
        return redirect('/promotions/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd($id);
        $promotion = Promotion::findOrFail($id);
        $deleted = $promotion->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete promotion']);
        }
        Session::flash('message', 'promotion deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $promotion = DB::table('promotions')->where('id',$id)->update([
            "active"=> 0
        ]);
        if(!$promotion){
            Session::flash('message', 'failed to deactivate promotion');
            return redirect('/brands');
        }
        Session::flash('message', 'promotion deactivated successfully');
        return Redirect::back();
    }
}
