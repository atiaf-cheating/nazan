<?php

namespace App\Http\Controllers;

use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(8);
        if(!$customers){
            return view('customers.index',['customers'=>[]]);
        }

        return view('customers.index',[ 'customers'=>$customers]);


    }
//    public function showSubCategories($id)
//    {
//        $allCategories = Category::where('active',1)->where('deleted_at',null)
//            ->where('parent_cat_id',$id)
//            ->orderBy('order', 'asc')
//            ->orderBy('created_at', 'asc')
//            ->paginate(8);
//        if(!$allCategories){
//            return view('categories.index',['categories'=>[]]);
//        }
//
//        return view('categories.index',[ 'categories'=>$allCategories]);
//
//
//    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
//        dd($id);
//        if($id == 0){
//            $parent_cat_name = '';
//        }else{
//            $parent_cat_name = Category::find($id)->english_name;
//        }
////        dd($parent_cat_name);
//        $categories = Category::where('active',1)
//            ->where('deleted_at',null)->get();
//        return view('categories.create',[
//            'categories'=>$categories,
//            'parent_cat_id'=>$id,
//            'parent_cat_name'=>$parent_cat_name
//        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
////        dd($request->all());
//        if($request->has('parent_cat_id')){
//            $parent_cat_id = $request->parent_cat_id;
//        }else{
//            $parent_cat_id = 0;
//        }
//        $request->validate([
//            'arabic_name' => 'required',
//            'english_name' => 'required',
//            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
//            'order' => 'required|numeric',
//            'parent_cat_id' => 'numeric',
//        ]);
//        $image = $request->file('image_url');
//        $uniqueName = time().'.'.$image->extension();
//
//        $destinationPath = public_path('images');
//
//        $image->move($destinationPath, $uniqueName);
//        $category = Category::create([
//            'arabic_name' => $request->arabic_name,
//            'english_name' => $request->english_name,
//            'order' => $request->order,
//            'parent_cat_id' => $parent_cat_id,
//            'image_url' => '',
//            'created_at' => Carbon::now()
//        ]);
//        $category->update([
//            'image_url' => $uniqueName ,
//        ]);
////        dd($category);
//        if(!$category){
//            Session::flash('message', 'failed to create category');
//            return redirect('/categories/'.$parent_cat_id);
//        }
//        Session::flash('message', 'category created successfully');
//        return redirect('/categories/'.$parent_cat_id);

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
//        $category = Category::findOrFail($id);
//        return view('categories.edit',["category"=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        $request->validate([
//            'arabic_name' => 'required',
//            'english_name' => 'required',
////            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
//            'order' => 'required|numeric',
//        ]);
//        $category=Category::findOrFail($id);
//        $updated = $category->update([
//            'arabic_name' => $request->arabic_name,
//            'english_name' => $request->english_name,
//            'order' => $request->order,
//            'updated_at' => Carbon::now()
//        ]);
//        $image = $request->file('image_url');
//        if($image){
//            $request->validate([
//                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
//            ]);
//            $uniqueName = time().'.'.$image->extension();
//
//            $destinationPath = public_path('images');
//
//            $image->move($destinationPath, $uniqueName);
//
//            $category->update([
//                'image_url' => $uniqueName ,
//            ]);
//        }
//        if(!$updated){
//            Session::flash('message', 'failed to update category');
//            return redirect('/categories');
//        }
//        Session::flash('message', 'category updated successfully');
//        return redirect('/categories');
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $category = Category::findOrFail($id);
//        $deleted = $category->delete();
//        if(!$deleted){
//            return Redirect::back()->withErrors(['msg', 'failed to delete category']);
//        }
//        Session::flash('message', 'category deleted successfully');
//        return Redirect::back();
    }
    public function activate($id)
    {
        $customer = Customer::where('id',$id)->first();
        if($customer->active == 0){
            $updateCustomer = Customer::where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'customer activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = Customer::where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'customer deactivated successfully');
            return Redirect::back();
        }

//        if(!$category){
            Session::flash('message', 'failed to deactivate customer');
            return redirect('/customers');
//        }

    }
}
