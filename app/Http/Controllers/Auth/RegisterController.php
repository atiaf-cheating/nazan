<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
//        $this->middleware('guest:customer');
//        $this->middleware('guest:merchant');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function showCustomerRegisterForm()
    {
        return view('customer.auth.register', ['url' => 'customer']);
    }

    protected function createCustomer(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'email'   => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'phone'=> 'required|numeric'
        ]);
        $customer = Customer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' =>Hash::make($request->password),
            'phone' => $request['phone'],
            'active' => 1,
            'verification_code' => 1234,
        ]);
        if($customer){
            Session::put(['customer'=>$customer]);
        }else{
            return back();
        }
        return redirect('customer/home');
    }
}
