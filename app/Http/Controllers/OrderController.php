<?php

namespace App\Http\Controllers;

use App\Merchant;
use App\Order;
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
//            $merchant = Merchant::find(session()->get('merchant_id'));
//            $orders = Order::where('merchant_id',session()->get('merchant_id'))->paginate(8);
//        }else{
            $orders = Order::paginate(8);
//        }
        return view('orders.index',['orders'=>$orders]);
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
        return view('orders.show',['order'=>$order]);
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
