<?php

namespace App\Http\Controllers\Merchant;

use App\Merchant;
use App\Order;
use App\OrderProduct;
use App\Product;
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
            $merchant = Merchant::find(session()->get('merchant_id'));
//            dd($merchant);
            $productOrders = OrderProduct::where('merchant_id',session()->get('merchant_id'))->get()->pluck('order_id')->unique();
//dd($productOrders);
//        }else{
            $orders = Order::whereIn('id',$productOrders)->paginate(8);
//        dd($orders);
//        }
        return view('merchant.orders.index',['orders'=>$orders]);
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
        $order = Order::where('id',$id)->with('orderProducts')->first();
//        dd($order);
//        foreach ($order->orderProducts as $product){
        $merchant = Merchant::find(session()->get('merchant_id'));
        $order->merchant= $merchant;
//        }
//        dd($order);
        return view('merchant.orders.show',['order'=>$order]);
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
//        dd('sssssssssssssssssssssssssssss');
        $order = Order::where('id',$id)->first();
        return view('merchant.orders.editstatus',['order'=>$order]);
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
            return redirect('merchant/control/orders');
        }
        Session::flash('message', 'status updated successfully');
//        return view('orders.index',['orders'=>  $orders]);
        return redirect('merchant/control/orders');

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
