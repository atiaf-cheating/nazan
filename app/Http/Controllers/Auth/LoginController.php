<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Controllers\Controller;
//use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
//        $this->middleware('guest:admin')->except('logout');
//        $this->middleware(\App\Http\Middleware\Customer::class)->except('logout');
    }
    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }
    public function logoutCustomer()
    {

        if(Session::has('customer')){
            Session::forget('customer');
        }
        return redirect()->back();
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function showCustomerLoginForm()
    {
//        dd('ddddddddd');
        return view('customer.auth.login', ['url' => 'customer']);
    }

    public function customerLogin(Request $request)
    {
//        dd($request);
//        dd(Auth::guard('customer'));
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        $customer = Customer::where([
            'email' => $request->email,
            'active' => 1,
        ])->first();
//        dd($customer);
        if($customer == null){
            Session::flash('message', 'customer not found');
            return back()->withInput($request->only('email', 'remember'));
        }
//        if($customer->active == 0){
//            Session::flash('message', 'access denied');
//            return back()->withInput($request->only('email', 'remember'));
//        }
        if(Hash::check($request->password,$customer->password)){
            if(Session::has('customer')){
//                dd('session exist');
                return redirect()->intended('/');
            }else{
//                dd('session not exist');
                Session::put('customer',$customer);
            }
//            dd('ssssss');
            return redirect('customer/home');

        }
//        dd($customer->password);
//        dd(Auth::guard('customer')->attempt(['email'=>$request['email'],'password'=>bcrypt($request['password'])]));
//        if(!Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
//            dd('eee');
//            return redirect()->back()->with(['fail'=>'Could Not Log You In']);
//        }
//        if (Auth::guard('customer')->attempt(['email' => $request['email'], 'password' =>Hash::make($request['password'])])) {
//            dd(  'true');
//
//            return redirect()->intended('/customer/home');
//        }
//        dd('sss');
        return back()->withInput($request->only('email', 'remember'));
    }

}
