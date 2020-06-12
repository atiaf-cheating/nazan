<?php

namespace App\Http\Controllers\Customer;

use App\Category;
use App\Merchant;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MerchantsController extends Controller
{

    public function merchantHome(){
      return view('merchantAuth.login');
    }
    public function merchantLogin(Request $request){
//        dd('gg');
        $merchant = Merchant::where('user_name', $request->email)
            ->orWhere('email', $request->email)
            ->where('active',1)
//            ->where('password', bcrypt($request->password))
            ->first();
        if(!$merchant){
            Session::flash('message', 'user not found');
            return redirect()->back();
        }
        $merchantExists = Hash::check($request->password , $merchant->password);
        if($merchant && $merchantExists){
            Session::put('merchant_token', $request->_token);
            Session::put('merchant_id', $merchant->id);
            $merchant->update([
                'remember_token' => $request->_token
            ]);
            if($request->remember){
                Session::put('remember_merchant', $request->remember);
            }

            $products = Product::where('active',1)
                ->where('deleted_at',null)
                ->where('merchant_id',$merchant->id)
                ->orderBy('order', 'asc')
                ->orderBy('arabic_name', 'asc')
                ->with('merchant')
                ->with('brand')
                ->with('category')
//            ->join('merchants','products.merchant_id','=','merchants.id')
                ->paginate(8);
            return view('products.index',['products'=>$products]);
        }
        Session::flash('message', 'wrong credentials');
        return redirect()->back();
    }
    public function merchantLogout(){
//        dd('gg');
        $merchant = Merchant::where('id',session()->get('merchant_id'))
//            ->orWhere('email', $request->email)
//            ->where('password', bcrypt($request->password))
            ->first();
        session()->forget('merchant_id');
        session()->forget('remember_merchant');

        return redirect('/merchant/control/login');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allMerchants = Merchant::paginate(8);
//        dd($allCategories);
        if(!$allMerchants){
            return view('merchants.index',['merchants'=>[]]);
        }

        return view('merchants.index',[ 'merchants'=>$allMerchants]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->user_name);
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'numeric',
            'email' => 'email',
        ]);
//        $token1 = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
//        $token = bin2hex($token1);

        $merchant = Merchant::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'user_name' => $request->user_name,
            'password' =>  Hash::make($request->password),
            'phone' => $request->phone,
            'email' => $request->email,

        ]);

        if(!$merchant){
            Session::flash('message', 'failed to create merchant');
            return redirect('/merchants');
        }
        Session::flash('message', 'merchant created successfully');
        return redirect('/merchants');

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
        $merchant = Merchant::findOrFail($id);
        return view('merchants.edit',["merchant"=>$merchant]);
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
            'user_name' => 'required',
            'phone' => 'numeric',
            'email' => 'email',
        ]);
        $merchant=Merchant::findOrFail($id);

        $updated = $merchant->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'user_name' => $request->user_name,
            'phone' => $request->phone,
            'email' => $request->email,

        ]);

        if(!$updated){
            Session::flash('message', 'failed to update merchant');
            return redirect('/merchants');
        }
        Session::flash('message', 'merchant updated successfully');
        return redirect('/merchants');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merchant = Merchant::findOrFail($id);
        $deleted = $merchant->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete merchant']);
        }
        Session::flash('message', 'merchant deleted successfully');
        return Redirect::back();
    }
    public function activate($id)
    {
        $merchant = DB::table('merchants')->where('id',$id)->update([
            "active"=> 0
        ]);
        if(!$merchant){
            Session::flash('message', 'failed to deactivate merchant');
            return redirect('/merchants');
        }
        Session::flash('message', 'merchant deactivated successfully');
        return Redirect::back();
    }
}
