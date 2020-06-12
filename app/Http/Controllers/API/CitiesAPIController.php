<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CitiesAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('parent_city_id')){
            $parent_city_id = $request->parent_city_id;
        }else{
            $parent_city_id = 0;
        }
        $allCities = City::where('active',1)
            ->where('deleted_at',null)
            ->where('parent_city_id',$parent_city_id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allCities){
            return response()->json(['message' => 'CITIES NOT FOUND'], 404);
        }
        return response()->json([
            'cities'=>$allCities
        ],200);

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
