<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBrands = Brand::where('deleted_at',null)
//            ->where('active',1)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allBrands){
            return view('brands.index',['brands'=>[]]);
        }

        return view('brands.index',[ 'brands'=>$allBrands]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $brands = Category::where('active',1)
//            ->where('deleted_at',null)->get();
        return view('brands.create');
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
        $brand = Brand::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);
        if($request->has('image_url')){
            $image = $request->file('image_url');
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/brands');

            $image->move($destinationPath, $uniqueName);

            $brand->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$brand){
            Session::flash('message', 'failed to create brand');
            return redirect('/brands/');
        }
        Session::flash('message', 'brand created successfully');
        return redirect('/brands/');

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
        $brand = Brand::findOrFail($id);
        return view('brands.edit',["brand"=>$brand]);
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
        $brand =Brand::findOrFail($id);
        $updated = $brand->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'updated_at' => Carbon::now()
        ]);
        if($request->has('image_url')){
            $image = $request->file('image_url');
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/brands');

            $image->move($destinationPath, $uniqueName);

            $brand->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update barnd');
            return redirect('/brands');
        }
        Session::flash('message', 'brand updated successfully');
        return redirect('/brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $deleted = $brand->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete brand']);
        }
        Session::flash('message', 'brand deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $brand = DB::table('brands')->where('id',$id)->first();
        if($brand->active == 0){
            $updateCustomer = DB::table('brands')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'brand activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('brands')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'brand deactivated successfully');
            return Redirect::back();
        }
        Session::flash('message', 'failed to deactivate brand');
            return redirect('/brands');

    }
}
