<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = 0)
    {
        $cat_id = request()->segment(2);

        $allCategories = Category::where('deleted_at',null)
//                ->where('active',1)
            ->where('parent_cat_id',$id)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->paginate(8);
        if(!$allCategories){
            return view('categories.index',['categories'=>[],'cat_id'=>$cat_id]);
        }

        return view('categories.index',[ 'categories'=>$allCategories,'cat_id'=>$cat_id]);


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
        if($id == 0){
            $parent_cat_name = '';
        }else{
            $parent_cat_name = Category::find($id)->english_name;
        }
//        dd($parent_cat_name);
        $categories = Category::where('active',1)
            ->where('deleted_at',null)->get();
        return view('categories.create',[
            'categories'=>$categories,
            'parent_cat_id'=>$id,
            'parent_cat_name'=>$parent_cat_name
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
//        dd($request->all());
        if($request->has('parent_cat_id')){
            $parent_cat_id = $request->parent_cat_id;
        }else{
            $parent_cat_id = 0;
        }
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'order' => 'required|numeric',
            'parent_cat_id' => 'numeric',
        ]);
        $image = $request->file('image_url');
        $uniqueName = time().'.'.$image->extension();

        $destinationPath = public_path('images/categories');

        $image->move($destinationPath, $uniqueName);
        $category = Category::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'parent_cat_id' => $parent_cat_id,
            'image_url' => '',
            'created_at' => Carbon::now()
        ]);
        $category->update([
            'image_url' => $uniqueName ,
        ]);
//        dd($category);
        if(!$category){
            Session::flash('message', 'failed to create category');
            return redirect('/categories/'.$parent_cat_id);
        }
        Session::flash('message', 'category created successfully');
        return redirect('/categories/'.$parent_cat_id);

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

    public function showSubCategories(Request $request)
        {
            if($request->has('id')){
                $id = $request->id;
                $subCategories = Category::where('deleted_at',null)
//                    ->where('active',1)
                    ->where('parent_cat_id',$id)
                    ->orderBy('order', 'asc')
                    ->orderBy('arabic_name', 'asc')
                    ->get();
            }else{
                $subCategories =[];
            }

            if(count($subCategories) == 0){
                return [];
            }
            return response()->json($subCategories);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit',["category"=>$category]);
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
//            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'order' => 'required|numeric',
        ]);
        $category=Category::findOrFail($id);
        $updated = $category->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'order' => $request->order,
            'updated_at' => Carbon::now()
        ]);
        $image = $request->file('image_url');
        if($image){
            $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/categories');

            $image->move($destinationPath, $uniqueName);

            $category->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update category');
            return redirect('/categories');
        }
        Session::flash('message', 'category updated successfully');
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $deleted = $category->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete category']);
        }
        $products = Product::where('cat_id',$category->id)->delete();
        $sizes = Size::where('cat_id',$category->id)->delete();
        Session::flash('message', 'category deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();
        if($category->active == 0){
            $updateCustomer = DB::table('categories')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'category activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('categories')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'category deactivated successfully');
            return Redirect::back();
        }
        Session::flash('message', 'error in category deactivation');
        return Redirect::back();
    }
}
