<?php

namespace App\Http\Controllers;

use App\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
    public function index()
    {
        $allgalleries = Gallery::where('deleted_at',null)
//            ->where('active',1)
            ->paginate(8);
        if(!$allgalleries){
            return view('galleries.index',['galleries'=>[]]);
        }

        return view('galleries.index',[ 'galleries'=>$allgalleries]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('galleries.create');
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
            'large_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'phone_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $largeImage = $request->file('large_image');
        $uniqueNameLarge = time().'.'.$largeImage->extension();
        $destinationPath = public_path('images/galleries');
        $largeImage->move($destinationPath, $uniqueNameLarge);

        $phone_image = $request->file('phone_image');
        $uniqueNamePhone = time().'.'.$phone_image->extension();
        $destinationPath = public_path('images/galleries');
        $phone_image->move($destinationPath, $uniqueNamePhone);

        $Gallery = Gallery::create([
            'phone_image' => $uniqueNamePhone,
            'large_image' => $uniqueNameLarge,
            'created_at' => Carbon::now()
        ]);
//dd($Gallery);
        if(!$Gallery){
            Session::flash('message', 'failed to create Gallery');
            return redirect('/galleries/');
        }
        Session::flash('message', 'Gallery created successfully');
        return redirect('/galleries/');

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
        $Gallery = Gallery::findOrFail($id);
        return view('galleries.edit',["gallery"=>$Gallery]);
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
            'large_image' => 'image|mimes:jpeg,png,jpg,gif',
            'phone_image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
        if($request->file('large_image') != null){
            $largeImage = $request->file('large_image');
            $uniqueNameLarge = time().'.'.$largeImage->extension();
            $destinationPath = public_path('images/galleries');
            $largeImage->move($destinationPath, $uniqueNameLarge);
            $updated = Gallery::where('id',$id)->update([
                'large_image' => $uniqueNameLarge,
                'updated_at' => Carbon::now()
            ]);
        }
        if($request->file('phone_image') != null) {
            $phone_image = $request->file('phone_image');
            $uniqueNamePhone = time() . '.' . $phone_image->extension();
            $destinationPath = public_path('images/galleries');
            $phone_image->move($destinationPath, $uniqueNamePhone);
            $updated = Gallery::where('id',$id)->update([
                'phone_image' => $uniqueNamePhone,
                'updated_at' => Carbon::now()
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update barnd');
            return redirect('/galleries');
        }
        Session::flash('message', 'Gallery updated successfully');
        return redirect('/galleries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Gallery = Gallery::findOrFail($id);
        $deleted = $Gallery->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete Gallery']);
        }
        Session::flash('message', 'Gallery deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $Gallery = DB::table('galleries')->where('id',$id)->first();
        if($Gallery->active == 0){
            $updateCustomer = DB::table('galleries')->where('id',$id)->update([
                "active"=> 1
            ]);
            Session::flash('message', 'Gallery activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = DB::table('galleries')->where('id',$id)->update([
                "active"=> 0
            ]);
            Session::flash('message', 'Gallery deactivated successfully');
            return Redirect::back();
        }
            Session::flash('message', 'failed to deactivate Gallery');
            return redirect('/galleries');

    }

}
