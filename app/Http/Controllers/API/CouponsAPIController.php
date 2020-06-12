<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Coupon;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponsAPIController extends Controller
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
    public function getDiscountPercentage(Request $request)
    {
        if(!$request->has('code')){
            return response()->json(['message' => 'code required'], 401);
        }
        $coupon = Coupon::where('code',$request->code)->first();
        if(!$coupon){
            return response()->json(['message' => 'coupon not found'], 404);
        }
        return response()->json([
            'coupon' => $coupon,
        ], 200);
    }
    public function getDeliveryPriceByCityID(Request $request)
    {
        if(!$request->has('city_id')){
            return response()->json(['message' => 'city_id required'], 401);
        }
        $city = City::where('id',$request->city_id)->first();
        if(!$city){
            return response()->json(['message' => 'city not found'], 404);
        }
        return response()->json([
            'city' => $city,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
