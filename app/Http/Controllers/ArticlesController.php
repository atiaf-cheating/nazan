<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_id = request()->segment(2);

        $allarticles = Article::where('deleted_at',null)
//        ->where('active',1)
            ->orderBy('order', 'asc')
            ->paginate(8);
        if(!$allarticles){
            return view('articles.index',['articles'=>[]]);
        }

        return view('articles.index',[ 'articles'=>$allarticles]);


    }
//    public function showSubarticles($id)
//    {
//        $allarticles = Article::where('active',1)->where('deleted_at',null)
//            ->where('parent_cat_id',$id)
//            ->orderBy('order', 'asc')
//            ->orderBy('created_at', 'asc')
//            ->paginate(8);
//        if(!$allarticles){
//            return view('articles.index',['articles'=>[]]);
//        }
//
//        return view('articles.index',[ 'articles'=>$allarticles]);
//
//
//    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
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
            'title' => 'required',
            'body' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'order' => 'required|numeric',
        ]);
        $image = $request->file('image_url');
        $uniqueName = time().'.'.$image->extension();

        $destinationPath = public_path('images/articles');

        $image->move($destinationPath, $uniqueName);
        $Article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'order' => $request->order,
            'image_url' => $uniqueName ,
            'created_at' => Carbon::now()
        ]);
//        dd($Article);
        if(!$Article){
            Session::flash('message', 'failed to create Article');
            return redirect('/articles/');
        }
        Session::flash('message', 'Article created successfully');
        return redirect('/articles/');

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
        $article = Article::findOrFail($id);
        return view('articles.edit',["article"=>$article]);
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
            'title' => 'required',
            'body' => 'required',
//            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'order' => 'required|numeric',
        ]);
        $Article=Article::findOrFail($id);
        $updated = $Article->update([
            'title' => $request->title,
            'body' => $request->body,
            'order' => $request->order,
//            'image_url' => $uniqueName ,
            'created_at' => Carbon::now()
        ]);
        $image = $request->file('image_url');
        if($image){
            $request->validate([
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/articles');

            $image->move($destinationPath, $uniqueName);

            $Article->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update Article');
            return redirect('/articles');
        }
        Session::flash('message', 'Article updated successfully');
        return redirect('/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Article = Article::findOrFail($id);
        $deleted = $Article->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete Article']);
        }
        Session::flash('message', 'Article deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $Article = DB::table('articles')->where('id',$id)->first();
        if($Article->active == 0){
            $updateCustomer = DB::table('articles')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'article activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('articles')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'Article deactivated successfully');
            return Redirect::back();
        }
        Session::flash('message', 'failed to deactivate Article');
            return redirect('/articles');

    }
}
