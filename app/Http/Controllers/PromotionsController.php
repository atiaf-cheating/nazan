<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    public function index()
    {
        $promotions = Promotion::where('deleted_at',null)
//            ->where('active',1)
            ->with('product')
            ->paginate(8);
        if(!$promotions){
            return view('promotions.index',['promotions'=>[]]);
        }

        return view('promotions.index',[ 'promotions'=>$promotions]);


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
        $allProducts = Product::where('deleted_at',null)
//            ->where('active',1)
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
        $promotion = DB::table('promotions')->where('id',$id)->first();
        if($promotion->active == 0){
            $updateCustomer = DB::table('promotions')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'promotion activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('promotions')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'promotion deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate promotion');
            return redirect('/promotions');

    }
}
