<?php

namespace App\Http\Controllers;

use App\Product;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::where('deleted_at',null)
//            ->where('active',1)
            ->paginate(8);
        if(!$coupons){
            return view('coupons.index',['coupons'=>[]]);
        }

        return view('coupons.index',[ 'coupons'=>$coupons]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.create');
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
            'code' => 'required',
            'discount_percentage' => 'required',
            'expiry_date' => 'required',
        ]);
        $foundCouponCode = Coupon::where('code',$request->code)->first();
        if($foundCouponCode){
            Session::flash('message', 'code already exists');
            return redirect()->back();
        }
        $coupon = coupon::create([
            'code' => $request->code,
            'expiry_date' => $request->expiry_date,
            'discount_percentage' => $request->discount_percentage,
            'created_at' => Carbon::now()
        ]);


        if(!$coupon){
            Session::flash('message', 'failed to create coupon');
            return redirect('/coupons/');
        }
        Session::flash('message', 'coupon created successfully');
        return redirect('/coupons/');

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
        $coupon = coupon::where('id',$id)->first();
        return view('coupons.edit',[
            "coupon"=>$coupon,
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
            'code' => 'required',
            'discount_percentage' => 'required',
            'expiry_date' => 'required',
        ]);
        $foundCouponCode = Coupon::where('code',$request->code)->where('id','!=',$id)->first();
        if($foundCouponCode){
            Session::flash('message', 'code already exists');
            return redirect()->back();
        }
        $coupon = coupon::where('id',$id)->update([
            'code' => $request->code,
            'expiry_date' => $request->expiry_date,
            'discount_percentage' => $request->discount_percentage,
            'created_at' => Carbon::now()
        ]);
        if(!$coupon){
            Session::flash('message', 'failed to update coupon');
            return redirect('/coupons/');
        }
        Session::flash('message', 'coupon updated successfully');
        return redirect('/coupons/');
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
        $coupon = coupon::findOrFail($id);
        $deleted = $coupon->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete coupon']);
        }
        Session::flash('message', 'coupon deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $coupon = DB::table('coupons')->where('id',$id)->first();
        if($coupon->active == 0){
            $updateCustomer = DB::table('coupons')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'coupon activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('coupons')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'coupon deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate coupon');
            return redirect('/brands');

    }
}
