<?php

namespace App\Http\Controllers;

use App\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = 0)
    {
        $allCities = City::where('deleted_at',null)
//            ->where('active',1)
            ->where('parent_city_id',$id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allCities){
            return view('cities.index',['cities'=>[]]);
        }

        return view('cities.index',[ 'cities'=>$allCities]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
        if($id == 0){
            $parent_city_name = '';
        }else{
            $parent_city_name = City::find($id)->english_name;
        }
        $cities = City::where('active',1)
            ->where('parent_city_id',$id)
            ->where('deleted_at',null)->get();
        return view('cities.create',[
            'cities'=>$cities,
            'parent_city_id'=>$id,
            'parent_city_name'=>$parent_city_name
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
        if($request->has('parent_city_id')){
            $parent_city_id = $request->parent_city_id;
        }else{
            $parent_city_id = 0;
        }
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'parent_city_id' => 'numeric',
//            'delivery_price' => 'numeric',
        ]);

        $city = City::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'parent_city_id' => $parent_city_id,
            'delivery_price' => $request->delivery_price,
            'created_at' => Carbon::now()
        ]);
        if(!$city){
            Session::flash('message', 'failed to create city');
            return redirect('/cities/'.$parent_city_id);
        }
        Session::flash('message', 'city created successfully');
        return redirect('/cities/'.$parent_city_id);
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
        $city = City::findOrFail($id);
        return view('cities.edit',["city"=>$city]);
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
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'delivery_price' => 'numeric',
        ]);
        $city=City::findOrFail($id);
        $updated = $city->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'delivery_price' => $request->delivery_price,
            'updated_at' => Carbon::now()
        ]);
        if(!$updated){
            Session::flash('message', 'failed to update city');
            return redirect('/cities');
        }
        Session::flash('message', 'city updated successfully');
        return redirect('/cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $deleted = $city->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete city']);
        }
        Session::flash('message', 'city deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $city = DB::table('cities')->where('id',$id)->first();
        if($city->active == 0){
            $updateCustomer = DB::table('cities')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'city activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('cities')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'city deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate city');
            return redirect('/cities');

    }
}
