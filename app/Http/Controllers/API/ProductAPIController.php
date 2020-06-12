<?php

namespace App\Http\Controllers\API;

use App\Color;
use App\Customer;
use App\Favourites;
use App\Http\Controllers\Controller;
use App\OrderProduct;
use App\Product;
use App\Review;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //auth
        $favourites =new Collection();
        if($request->has('token')){
            $foundToken = Token::where('token',$request->token)->first();
            if($foundToken){
                $customer = Customer::where('id', $foundToken->user_id)->first();
                if($customer) {
                    $allFavourites = DB::table('favourites')->where('user_id', $customer->id)->get();
                    if(count($allFavourites) > 0){
                        $favourites = $allFavourites->pluck('product_id');
                    }
                }
            }
        }
        if($request->has('cat_id') && $request->has('brand_id')){
            $products = Product::
            where('cat_id', $request->cat_id)
                ->where('brand_id',$request->brand_id)
                ->where('active',1)
                ->where('deleted_at',null)
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->orderBy('created_at','DESC')
                ->with('reviews')
                ->with('merchant')
                ->with('attachments')
                ->paginate(8);
            foreach ($products as $product){
                $allProductColors = DB::table('color_product')
                    ->where('product_id',$product->id)
                    ->where('active',1)
                    ->where('deleted_at',null)
                    ->get()->pluck('color_id')->unique();
                $allColors = Color::whereIn('id',$allProductColors)
                    ->where('active',1)
                    ->where('deleted_at',null)
                    ->orderBy('order', 'asc')
                    ->with('sizes.sizes')
                    ->get();
                $product['colors']=$allColors;
//                dd($favourites);
                if(in_array($product->id,$favourites->toArray())){
                    $product['is_favourite']=true;
                }else{
                    $product['is_favourite']=false;
                }
            }
            return response()->json(['products' =>$products], 200);
        }
        if($request->has('cat_id')){
        $products = Product::
        where('cat_id', $request->cat_id)
            ->where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->orderBy('created_at','DESC')
            ->with('reviews')
            ->with('merchant')
            ->with('attachments')

            ->paginate(8);
        foreach ($products as $product){
            $allProductColors = DB::table('color_product')
                ->where('product_id',$product->id)
                ->where('active',1)
                ->where('deleted_at',null)
                ->get()->pluck('color_id')->unique();
            $allColors = Color::whereIn('id',$allProductColors)
                ->where('active',1)
                ->where('deleted_at',null)
                ->orderBy('order', 'asc')
                ->with('sizes.sizes')
                ->get();
            $product['colors']=$allColors;
            if(in_array($product->id,$favourites->toArray())){
                $product['is_favourite']=true;
            }else{
                $product['is_favourite']=false;
            }

        }
        return response()->json(['products' =>$products], 200);

    }
        if($request->has('brand_id')){
        $products = Product::
        where('brand_id', $request->brand_id)
            ->where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('created_at','DESC')
            ->with('reviews')
            ->with('attachments')
            ->with('merchant')
            ->paginate(8);
        foreach ($products as $product){
            $allProductColors = DB::table('color_product')
                ->where('product_id',$product->id)
                ->where('active',1)
                ->where('deleted_at',null)
                ->get()->pluck('color_id')->unique();
            $allColors = Color::whereIn('id',$allProductColors)
                ->where('active',1)
                ->where('deleted_at',null)
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->with('sizes.sizes')
                ->get();
            $product['colors']=$allColors;
            if(in_array($product->id,$favourites->toArray())){
                $product['is_favourite']=true;
            }else{
                $product['is_favourite']=false;
            }

        }
        return response()->json(['products' =>$products], 200);
    }
        $products = Product::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->orderBy('created_at','DESC')
            ->with('reviews')
            ->with('attachments')
            ->with('merchant')
            ->paginate(8);
        foreach ($products as $product){
            $allProductColors = DB::table('color_product')
                ->where('product_id',$product->id)
                ->where('active',1)
                ->where('deleted_at',null)
                ->get()->pluck('color_id')->unique();
            $allColors = Color::whereIn('id',$allProductColors)
                ->where('active',1)
                ->where('deleted_at',null)
                ->orderBy('order', 'asc')
                ->with('sizes.sizes')
                ->get();
            $product['colors']=$allColors;
            if(in_array($product->id,$favourites->toArray())){
                $product['is_favourite']=true;
            }else{
                $product['is_favourite']=false;
            }

        }
        return response()->json(['products' =>$products], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }
    public function addReview(Request $request)
    {

        if(!$request->has('product_id')){
            return response()->json(['message' => 'product_id required'], 401);
        }
        //auth
        if(!$request->has('token')){
            return response()->json(['message' => 'access denied'], 401);
        }
        $foundToken = Token::where('token',$request->token)->first();
        if(!$foundToken){
            return response()->json(['message' => 'access denied'], 400);
        }

        $customer = Customer::where('id',$foundToken->user_id)->first();

        $product = OrderProduct::where('product_id',$request->product_id)->with('order')->first();
        if(!$product){
            return response()->json(['message' => 'product not found'], 400);
        }
//        dd($customer->id );
        if($product->order->customer_id != $customer->id){
            return response()->json(['message' => 'access denied'], 400);
        }
        if( !$request->has('product_id') || !$request->has('review')){
            return response()->json(['message' => 'review required'], 400);
        }
        $addReview = Review::create([
            'user_id'=> $customer->id,
            'product_id'=> $request->product_id,
            'review'=> $request->review,
            'comment'=> $request->comment,
        ]);
        if(!$addReview){
            return response()->json(['message' => 'error creating review'], 401);
        }
        return response()->json(['message' => 'review added successfully'], 200);

    }

    public function getProductReviewsByID(Request $request)
    {
        if(!$request->has('product_id')){
            return response()->json(['message' => 'product_id required'], 401);
        }
        $reviews = Review::where('product_id',$request->product_id)->with('customer')->get();
        if(!$reviews){
            return response()->json(['message' => 'data not found'], 400);
        }
        $allReview = 0;
        foreach ($reviews as $review) {
            $allReview  += $review->review;
        }
        $reviewsCount = count($reviews);
        if(count($reviews) != 0){
            $productReviews = $allReview /$reviewsCount;
        }else{
            $productReviews = null;
        }
        return response()->json([
            'reviews' => $reviews,
            'total_review' => $productReviews,
        ], 200);
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
    public function show(Request $request)
    {
        if(!$request->has('product_id')) {
            return response()->json(['message' =>'product id required'], 400);
        }
        $favourites = new Collection();
        if($request->has('token')){
            $foundToken = Token::where('token',$request->token)->first();
            if($foundToken){
                $customer = Customer::where('id', $foundToken->user_id)->first();
                if($customer) {
                    $allFavourites = DB::table('favourites')->where('user_id', $customer->id)->get();
                    if(count($allFavourites) > 0){
                        $favourites = $allFavourites->pluck('product_id');
                    }
                }
            }
        }
        $product = Product::where('id', $request->product_id)->with('reviews')->with('merchant')->with('attachments')->first();
        $reviewsValues = $product->reviews->pluck('review');
        $totalReview = 0;
        $reviewSum = 0;
        foreach($reviewsValues as $value){
            $reviewSum += $value;
        }
        if(count($reviewsValues) == 0){
            $totalReview = 0;
        }else{
            $totalReview = $reviewSum / count($reviewsValues);
        }
        $product['total_reviews']=$totalReview;
        $allProductColors = DB::table('color_product')
            ->where('product_id',$product->id)
            ->where('active',1)
            ->where('deleted_at',null)
            ->get()->pluck('color_id')->unique();
        $allColors = Color::whereIn('id',$allProductColors)
            ->where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->with('sizes.sizes')
            ->get();
        $product['colors']=$allColors;
        if(in_array($product->id,$favourites->toArray())){
            $product['is_favourite']=true;
        }else{
            $product['is_favourite']=false;
        }
        return response()->json(['products' =>$product], 200);
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
