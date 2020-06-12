<?php

namespace App\Http\Controllers;

use App\Color;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allColors = Color::where('deleted_at',null)
            ->where('active',1)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allColors){
            return view('colors.index',['colors'=>[]]);
        }

        return view('colors.index',[ 'colors'=>$allColors]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('colors.create');
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
        ]);
        $color = Color::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);

        if(!$color){
            Session::flash('message', 'failed to create color');
            return redirect('/colors/');
        }
        Session::flash('message', 'color created successfully');
        return redirect('/colors/');

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
        $color = Color::findOrFail($id);
        return view('colors.edit',["color"=>$color]);
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
        ]);
        $color =Color::findOrFail($id);
        $updated = $color->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'updated_at' => Carbon::now()
        ]);
        if(!$updated){
            Session::flash('message', 'failed to update color');
            return redirect('/colors');
        }
        Session::flash('message', 'color updated successfully');
        return redirect('/colors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $deleted = $color->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete color']);
        }
        Session::flash('message', 'color deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $color = DB::table('colors')->where('id',$id)->first();
        if($color->active == 0){
            $updateCustomer = DB::table('colors')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'color activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('colors')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'color deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate color');
            return redirect('/colors');


    }
}
