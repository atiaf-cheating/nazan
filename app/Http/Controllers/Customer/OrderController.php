<?php

namespace App\Http\Controllers\Customer;

use App\Brand;
use App\Category;
use App\City;
use App\Color;
use App\ColorSize;
use App\Coupon;
use App\Merchant;
use App\Order;
use App\Product;
use App\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(session()->has('merchant_id')){
//            $merchant = Merchant::find(session()->get('merchant_id'));
//            $orders = Order::where('merchant_id',session()->get('merchant_id'))->paginate(8);
//        }else{
//            $orders = Order::paginate(8);
//        }
        if(!Session::has('customer')){
            return redirect('login/customer');
        }
        $customer = Session::get('customer');
        $orders = Order::where('customer_id',$customer->id)->with('orderProducts')->get();
//dd($orders);
        return view('customer.orders.index',['orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $city = City::find($request->city);
        $cart = Session::get('cart');
//        dd($cart);

        if($request->promo_code != null) {
            $coupon_code =$request->promo_code;
            $coupon = DB::table('coupons')
                ->where('code', $request->promo_code)
                ->where('active', 1)
                ->where('deleted_at', null)
                ->where('expiry_date', '>', Carbon::now()->toDateString())
                ->first();
            if(!$coupon){
                $coupon_discount_percentage = 0;
                $orderPriceAfterCouponDiscount =$cart->totalPrice  ;
                $expiryDate = null;
            }else{
                $expiryDate = $coupon->expiry_date;
                if(Carbon::now()->toDateString() < $expiryDate){
                    $coupon_discount_percentage = $coupon->discount_percentage;
                    $orderPriceAfterCouponDiscount = $cart->totalPrice - $cart->totalPrice*$coupon_discount_percentage/100;
                }else{
                    $coupon_discount_percentage = 0;
                    $orderPriceAfterCouponDiscount =$cart->totalPrice  ;
                }
            }
        }else{
            $coupon_code ='';
            $orderPriceAfterCouponDiscount =$cart->totalPrice  ;
        }
        $customer = Session::get('customer');
        if(!$customer){
            return redirect('login/customer');
        }
        $createOrder = Order::insertGetId([
            'status' => 1,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
            'city_id' => $request->city,
            'parent_city_id' => $city->parent_city_id,
            'city_arabic_name' => $city->arabic_name,
            'city_english_name' => $city->english_name,
            'delivery_price' => $city->delivery_price,
            'street' => $request->street,
            'building_number' => $request->building,
            'total_price' => strval($orderPriceAfterCouponDiscount),
            'coupon_discount_percentage' => $coupon_discount_percentage ,
            'coupon_code' => $coupon_code,
            'coupon_expiry_date' => $expiryDate,
            'paymentMethod_id' => 1,
            'created_at' => Carbon::now(),
        ]);
        if(!$createOrder){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Error creating order');
            return redirect()->back();
        }
        foreach($cart->products as $product){
            $productCategory = Category::find($product['cat_id']);
            $brand = Brand::find($product['brand_id']);
            $color = Color::find($product['color_id']);
            $colorSize = ColorSize::find($product['size_id']);
//            dd($colorSize);
            $size = Size::where('id',$colorSize->size_id)->first();
//            dd($product['discount']);
            if($product['discount'] == null){
                $product_price_discount = 0;
                $productPrice =$product['price'];
            }else{
                $product_price_discount = $product['discount'];
                $productPrice =$product['price'] - $product['price']*$product['discount'] /100;
            }
            $createOrderProduct = DB::table('order_product')->insert([
                'order_id'=> $createOrder,
                'product_id'=> $product['id'],
                'merchant_id'=> $product['merchant_id'],
                'product_arabic_name'=> $product['arabic_name'],
                'product_english_name'=> $product['english_name'],
                'product_description'=> $product['description'],
                'product_image_url'=> $product['image_url'],
                'product_cat_id'=> $product['cat_id'],
                'product_category_arabic_name'=> $productCategory->arabic_name,
                'product_category_english_name'=> $productCategory->english_name,
                'product_parent_cat_id'=> $productCategory->parent_cat_id,
                'product_brand_id'=> $product['brand_id'],
                'product_brand_arabic_name'=> $brand->arabic_name,
                'product_brand_english_name'=> $brand->english_name,
                'product_color_id'=> $product['color_id'],
                'product_color_arabic_name'=> $color->arabic_name,
                'product_color_english_name'=> $color->english_name,
                'product_size_id'=> $product['size_id'],
                'product_size_arabic_name'=> $size->arabic_name,
                'product_size_english_name'=> $size->english_name,
                'product_size_cat_id'=> $size->cat_id,
                'product_price'=> strval($productPrice),
                'product_price_discount'=> $product_price_discount,
                'created_at'=> Carbon::now(),
            ]);
            if(!$createOrderProduct){
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'Error creating order');
                return redirect('customer/checkout');
            }
        }
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Order created successfully');
        Session::forget('cart');
        return redirect('customer/orders');
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
        $order = Order::where('id',$id)->with('orderProducts')->first();
        foreach ($order->orderProducts as $product){
            $merchant = Merchant::find($product->merchant_id);
            $product->merchant= $merchant;
        }
        return view('customer.orders.show',['order'=>$order]);
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
    public function editStatus($id)
    {
        $order = Order::where('id',$id)->first();
        return view('orders.editstatus',['order'=>$order]);
    }

    public function updateStatus(Request $request , $id)
    {
//        dd($request->status);
        $order = Order::where('id',$id)->first();
        $updated = DB::table('orders')->where('id',$id)->update(['status'=>$request->status]);
//        dd($updated);
        $orders = Order::paginate(8);
        if(!$updated){
            Session::flash('message', 'failed to update status');
            return redirect('/orders');
        }
        Session::flash('message', 'status updated successfully');
//        return view('orders.index',['orders'=>  $orders]);
        return redirect('/orders');

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
