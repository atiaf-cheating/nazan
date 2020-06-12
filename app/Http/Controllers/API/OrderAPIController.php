<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Order;
use App\Token;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class OrderAPIController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

//        if(!$request->has('status') || !$request->has('merchant_id')|| !$request->has('customer_id') || !$request->has('customer_name') || !$request->has('customer_email') ||
//        !$request->has('customer_phone') || !$request->has('city_id') || !$request->has('parent_city_id') || !$request->has('city_arabic_name') ||
//        !$request->has('city_english_name') || !$request->has('street') || !$request->has('building_number') ||
//        !$request->has('coupon_code') || !$request->has('coupon_discount_percentage') || !$request->has('coupon_expiry_date')){
//            return response()->json(['message' => 'bad request, missing parameters'], 400);
//        }
        $foundOrder = Order::where([
            "status" => $request->status,
//            'merchant_id' => $request->merchant_id,
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'city_id' => $request->city_id,
            'parent_city_id' =>$request->parent_city_id,
            'city_arabic_name' => $request->city_arabic_name,
            'city_english_name' => $request->city_english_name,
            'street' => $request->street,
            'building_number' =>$request->building_number,
            'delivery_price' =>$request->delivery_price,
            'coupon_code' => $request->coupon_code,
            'coupon_discount_percentage' => $request->coupon_discount_percentage,
            'coupon_expiry_date' =>$request->coupon_expiry_date
        ])->first();
        if($foundOrder){
            return response()->json(['message' => 'order  already exists'], 401);
        }
        $order =Order::create([
            "status" => $request->status,
//            'merchant_id' => $request->merchant_id,
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'city_id' => $request->city_id,
            'parent_city_id' =>$request->parent_city_id,
            'city_arabic_name' => $request->city_arabic_name,
            'city_english_name' => $request->city_english_name,
//            'edit_status' => $request->edit_status,
            'street' => $request->street,
            'building_number' =>$request->building_number,
            'delivery_price' =>$request->delivery_price,
            'coupon_code' => $request->coupon_code,
            'coupon_discount_percentage' => $request->coupon_discount_percentage,
            'coupon_expiry_date' =>$request->coupon_expiry_date,
            'paymentMethod_id' =>$request->paymentMethod_id,
            'created_at' =>Carbon::now()
        ]);
        if(!$order){
            return response()->json(['message' => 'error creating order'], 400);
        }
        $products = $request->products;
//        dd($products);
            foreach (json_decode($products) as $product) {
//            $foundOrderProduct = DB::table('order_product')->where([
//                "order_id" => $order->id,
//                'product_id' => $product->product_id,
//                'product_arabic_name' => $product->product_arabic_name,
//                'product_english_name' => $product->product_english_name,
//                'product_description' => $product->product_description,
//                'product_image_url' => $product->product_image_url,
//                'product_cat_id' => $product->product_cat_id,
//                'product_category_arabic_name' => $product->product_category_arabic_name,
//                'product_category_english_name' => $product->product_category_english_name,
//                'product_parent_cat_id' => $product->product_parent_cat_id,
//                'product_brand_id' => $product->product_brand_id,
//                'product_brand_arabic_name' => $product->product_brand_arabic_name,
//                'product_brand_english_name' => $product->product_brand_english_name,
//                'product_color_id' => $product->product_color_id,
//                'product_color_arabic_name' => $product->product_color_arabic_name,
//                'product_color_english_name' => $product->product_color_english_name,
//                'product_size_id' => $product->product_size_id,
//                'product_size_arabic_name' => $product->product_size_arabic_name,
//                'product_size_english_name' => $product->product_size_english_name,
//                'product_size_cat_id' => $product->product_size_cat_id,
//                'product_price' => $product->product_price,
//                'product_price_discount' => $product->product_price_discount,
//            ])->first();
//            dd($product);
//            if (!$foundOrderProduct) {
                $productOrder = DB::table('order_product')->insert([
//                        "order_id" => $order->id,
//                        'product_id' => $product['product_id'],
//                        'product_arabic_name' => $product['product_arabic_name'],
//                        'product_english_name' => $product['product_english_name'],
//                        'product_description' => $product['product_description'],
//                        'product_image_url' => $product['product_image_url'],
//                        'product_cat_id' => $product['product_cat_id'],
//                        'product_category_arabic_name' => $product['product_category_arabic_name'],
//                        'product_category_english_name' => $product['product_category_english_name'],
//                        'product_parent_cat_id' => $product['product_parent_cat_id'],
//                        'product_brand_id' => $product['product_brand_id'],
//                        'product_brand_arabic_name' => $product['product_brand_arabic_name'],
//                        'product_brand_english_name' => $product['product_brand_english_name'],
//                        'product_color_id' => $product['product_color_id'],
//                        'product_color_arabic_name' => $product['product_color_arabic_name'],
//                        'product_color_english_name' => $product['product_color_english_name'],
//                        'product_size_id' => $product['product_size_id'],
//                        'product_size_arabic_name' => $product['product_size_arabic_name'],
//                        'product_size_english_name' => $product['product_size_english_name'],
//                        'product_size_cat_id' => $product['product_size_cat_id'],
//                        'product_price' => $product['product_price'],
//                        'product_price_discount' => $product['product_price_discount'],
                        'created_at' => Carbon::now(),
                        "order_id" => $order->id,
            'merchant_id' => $product->merchant_id,
                'product_id' => $product->product_id,
                'product_arabic_name' => $product->product_arabic_name,
                'product_english_name' => $product->product_english_name,
                'product_description' => $product->product_description,
                'product_image_url' => '',
                'product_cat_id' => $product->product_cat_id,
                'product_category_arabic_name' => $product->product_category_arabic_name,
                'product_category_english_name' => $product->product_category_english_name,
                'product_parent_cat_id' => $product->product_parent_cat_id,
                'product_brand_id' => $product->product_brand_id,
                'product_brand_arabic_name' => $product->product_brand_arabic_name,
                'product_brand_english_name' => $product->product_brand_english_name,
                'product_color_id' => $product->product_color_id,
                'product_color_arabic_name' => $product->product_color_arabic_name,
                'product_color_english_name' => $product->product_color_english_name,
                'product_size_id' => $product->product_size_id,
                'product_size_arabic_name' => $product->product_size_arabic_name,
                'product_size_english_name' => $product->product_size_english_name,
                'product_size_cat_id' => $product->product_size_cat_id,
                'product_price' => $product->product_price,
                'product_price_discount' => $product->product_price_discount,
                ]);
//                dd($productOrder);
                if($product->product_image_url){
                    $image = $product->product_image_url;
                    $uniqueName = time().'.'.$image->extension();

                    $destinationPath = public_path('images/orders');

                    $image->move($destinationPath, $uniqueName);

                    $productOrder->update([
                        'product_image_url' => $uniqueName ,
                    ]);
                }
            }
//        }
        if(!$order){
            return response()->json(['message' => 'error creating order'], 400);
        }
        return response()->json(['message' => 'order created successfully'], 200);

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

    public function getUserOrders(Request $request)
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
        $orders = Order::where('customer_id',$customer->id)->with('orderProducts')->get();
        if(!$orders){
            return response()->json(['message' => 'orders not found'], 404);
        }
        return response()->json(['orders' => $orders], 400);
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
