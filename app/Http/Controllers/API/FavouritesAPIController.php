<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Favourites;
use App\Http\Controllers\Controller;
use App\Token;
use Illuminate\Http\Request;

class FavouritesAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->has('token')){
            return response()->json(['message' => 'token required'], 401);
        }
        $foundToken = Token::where('token',$request->token)->first();
        if(!$foundToken){
            return response()->json(['message' => 'invalid token'], 400);
        }

        $customer = Customer::where('id',$foundToken->user_id)->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        $favourites = Favourites::where('user_id', $customer->id)->with('product')
            ->where('deleted_at',null)
            ->get();
        if(!$favourites){
            return response()->json(['message' => 'favourites not found'], 404);
        }
        return response()->json(['favourites' =>$favourites], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has('token') || !$request->has('product_id')){
            return response()->json(['message' => 'token and product required'], 401);
        }
        $foundToken = Token::where('token',$request->token)->first();
        if(!$foundToken){
            return response()->json(['message' => 'invalid token'], 400);
        }

        $customer = Customer::where('id',$foundToken->user_id)->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        $favourites = Favourites::create([
            'user_id'=>$customer->id,
            'product_id'=>$request->product_id
        ]);
        if(!$favourites){
            return response()->json(['message' => 'failed to add to favourites'], 404);
        }
        return response()->json(['favourites' =>$favourites], 200);
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
    public function destroy(Request $request)
    {
        if(!$request->has('token') || !$request->has('product_id')){
            return response()->json(['message' => 'token and product required'], 401);
        }
        $foundToken = Token::where('token',$request->token)->first();
        if(!$foundToken){
            return response()->json(['message' => 'invalid token'], 400);
        }

        $customer = Customer::where('id',$foundToken->user_id)->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        $favourites = Favourites::where( 'user_id',$customer->id)
        ->where('product_id',$request->product_id)
        ->first();
        if(!$favourites){
            return response()->json(['message' => 'product not found'], 404);
        }
        $deleteFavourote = $favourites->delete();
        return response()->json(['favourites' =>$deleteFavourote], 200);
    }
}
