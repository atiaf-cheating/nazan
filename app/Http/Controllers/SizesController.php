<?php

namespace App\Http\Controllers;

use App\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cat_id =(int) request()->segment(2);
        $allSizes = Size::where('deleted_at',null)
//            -where('active',1)
            ->where('cat_id',$cat_id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allSizes){
            return view('sizes.index',[
                'sizes'=>[],
                'cat_id'=>$cat_id,
            ]);
        }

        return view('sizes.index',[
            'sizes'=>$allSizes,
            'cat_id'=>$cat_id,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cat_id = (int) request()->segment(3);
//    dd($cat_id);
        return view('sizes.create',['cat_id'=>$cat_id]);
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
        $size= Size::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'cat_id' => $request->cat_id,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);

        if(!$size){
            Session::flash('message', 'failed to create size');
            return redirect('/sizes/'.$request->cat_id);
        }
        Session::flash('message', 'size created successfully');
        return redirect('/sizes/'.$request->cat_id);

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
        $size = Size::findOrFail($id);
        return view('sizes.edit',["size"=>$size]);
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
        $size =Size::findOrFail($id);
        $updated = $size->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'cat_id' => $request->cat_id,
            'updated_at' => Carbon::now()
        ]);
        if(!$updated){
            Session::flash('message', 'failed to update size');
            return redirect('/sizes/'.$request->cat_id);
        }
        Session::flash('message', 'size updated successfully');
        return redirect('/sizes/'.$request->cat_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $deleted = $size->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete size']);
        }
        Session::flash('message', 'size deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $size = DB::table('sizes')->where('id',$id)->first();
        if($size->active == 0){
            $updateCustomer = DB::table('sizes')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'size activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('sizes')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'size deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate size');
            return redirect('/sizes');

    }
}
