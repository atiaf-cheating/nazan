<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsAPIController extends Controller
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

    public function aboutUS()
    {
        $about_us = DB::table('about_us')->where('id',1)->first();
        if(!$about_us){
            return response()->json(['message' => 'DATA NOT FOUND'], 404);
        }
//        dd($about_us);
        return response()->json([
            'about'=>$about_us
        ],200);
    }

    public function terms()
    {
        $terms = DB::table('usage_policy')->where('id',1)->first();
        if(!$terms){
            return response()->json(['message' => 'DATA NOT FOUND'], 404);
        }
//        dd($about_us);
        return response()->json([
            'terms'=>$terms
        ],200);
    }

    public function settings()
    {
        $info = DB::table('settings')->where('id',1)->first();
        if(!$info){
            return response()->json(['message' => 'DATA NOT FOUND'], 404);
        }
//        dd($about_us);
        return response()->json([
            'info'=>$info
        ],200);
    }

    public function message(Request $request)
    {

        if(!$request->has('name') || !$request->has('email') || !$request->has('message') || !$request->has('category')){
            return response()->json(['message' => 'phone, name, email, message and category required'], 401);
        }
         if(!in_array($request->category , ['suggestion','complaint'])){
             return response()->json(['message' => 'category must be suggestion or complaint'], 401);
         }
         $message = DB::table('mail_inboxes')->insert([
             'name'=> $request->name,
             'email'=> $request->email,
             'message'=> $request->message,
             'category'=> $request->category,
             'created_at'=> Carbon::now()
         ]);
         if(!$message){
             return response()->json(['message' => 'error sending message'], 400);
         }
        return response()->json([
            'message' => $message,
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
