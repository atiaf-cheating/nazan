<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAPIController extends Controller
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

    public function login(Request $request)
    {
        if(!$request->has('phone_email')){
            return response()->json(['message' => 'phone or email required'], 401);
        }
        if(!$request->has('password')){
            return response()->json(['message' => 'password is required'], 401);
        }
        $customer =Customer::where('phone',$request->phone_email)
            ->orWhere('email',$request->phone_email)
//            ->where('password',Hash::make($request->password))
            ->where('deleted_at',null)
            ->where('active',1)
            ->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        $comparePassword = Hash::check($request->password , $customer->password);
//        dd($comparePassword);
        if($comparePassword == false){
            return response()->json(['message' => 'wrong password'], 400);
        }
        $foundToken = Token::where('user_id',$customer->id)->where('deleted_at',null)->first();
        if($foundToken){
            return response()->json([
                'customer' => $customer,
                'token' => $foundToken->token,
                ], 200);
        }
        //Generate a random string.
        $token1 = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token1);
        $insertToken = Token::create([
            'user_id'=> $customer->id,
            'token'=> $token,
            'created_at'=> Carbon::now(),
        ]);
        return response()->json([
            'customer' => $customer,
            'token' => $token,
            ], 200);
    }

    public function registerPhone(Request $request)
    {
        if(!$request->has('phone')){
            return response()->json(['message' => 'phone is required'], 401);
        }
        $foundCustomer = Customer::where('phone',$request->phone)->where('deleted_at',null)->first();
        if($foundCustomer){
            return response()->json(['message' => ' phone number already exists'], 400);
        }
        $createCustomer = Customer::create([
            'phone'=>$request->phone,
            'email'=>'',
            'name'=>'',
            'verification_code'=>'1234',
            'password'=>'',
            'active'=>1,
            'created_at'=>Carbon::now()
        ]);
        if(!$createCustomer){
            return response()->json(['message' => 'phone is required'], 401);
        }
        return response()->json(['verification_code' => '1234'], 200);
    }
    public function resumeRegistration(Request $request)
    {
        if(!$request->has('name') || !$request->has('email') || !$request->has('password') || !$request->has('phone')){
            return response()->json(['message' => 'phone, name, email and password required'], 401);
        }
        $foundCustomer = Customer::where('phone',$request->phone)
            ->where('deleted_at',null)->first();
        if(!$foundCustomer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        if($foundCustomer){
            //Generate a random string.
            $token1 = openssl_random_pseudo_bytes(16);
            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token1);
//            dd($token);
            $foundCustomer->update([
                'email'=>$request->email,
                'name'=>$request->name,
//                'image_url'=>$request->name,
                'password'=>Hash::make($request->password),
            ]);
            if($request->hasFile('image_url')){
                $image = $request->file('image_url');
                $uniqueName = time().'.'.$image->extension();

                $destinationPath = public_path('images/customers');

                $image->move($destinationPath, $uniqueName);

                Customer::where('id',$request->id)->update([
                    'image_url' => $uniqueName ,
                ]);
            }
            $insertToken = Token::create([
                'user_id'=> $foundCustomer->id,
                'token'=> $token,
                'created_at'=> Carbon::now(),
            ]);
            return response()->json([
                'customer' => $foundCustomer,
                'token' => $token,
            ], 200);
        }
        return response()->json(['message' => 'error creating customer'], 400);
    }

    public function forgotPassword(Request $request)
    {
        if(!$request->has('phone')){
            return response()->json(['message' => 'phone number required'], 400);
        }
        $customer = Customer::where('phone',$request->phone)
            ->where('active',1)
            ->where('deleted_at',null)
            ->first();
         $token = Token::where('user_id',$customer->id)->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 400);
        }
        $customer->update([
            'verification_code'=> '1234'
        ]);
        return response()->json([
            'confirmation_code' => '1234',
            'token' => $token->token,

            ], 200);
    }
    public function changePassword(Request $request)
    {
        if(!$request->has('new_password') || !$request->has('confirmation_code') || !$request->has('token')){
            return response()->json(['message' => 'phone, token and confirmation_code required'], 400);
        }
        $userId = Token::where('token',$request->token)->first();
        $customer = Customer::where('id',$userId->user_id)
            ->where('active',1)
            ->where('deleted_at',null)
            ->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 400);
        }
        $customer->update([
            'password'=> Hash::make($request->new_password)
        ]);
        return response()->json(['message' => $customer], 200);
    }
    public function logout(Request $request)
    {
        if(!$request->has('token')){
            return response()->json(['message' => 'token required'], 401);
        }
        $foundToken = Token::where('token',$request->token)->first();
        if(!$foundToken){
            return response()->json(['message' => 'invalid token'], 400);
        }
        $foundToken->delete();
        return response()->json(['message' => 'logout succeeded'], 200);
    }
    public function editProfile(Request $request)
    {
        $customer = Customer::where('id',$request->id)->first();
        if(!$customer){
            return response()->json(['message' => 'customer not found'], 404);
        }
        if(!$request->has('token')){
            return response()->json(['message' => 'token required'], 400);
        }
        $foundToken = Token::where('user_id',$request->id)
            ->where('token',$request->token)
            ->first();
        if(!$foundToken){
            return response()->json(['message' => 'authentication failed'], 400);
        }
        $updateCustomer  = $customer->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
        ]);
        if($request->hasFile('image_url')){
//            dd('fff');
            $image = $request->file('image_url');
//
            $uniqueName = time().'.'.$image->getClientOriginalName();
            $destinationPath = public_path('images/customers');

            $image->move($destinationPath, $uniqueName);

            $update = Customer::where('id',$request->id)->update([
                'image_url' => $uniqueName ,
            ]);

        }
        $customer = Customer::where('id',$request->id)->first();

        if(!$updateCustomer){
            return response()->json(['message' => 'failed to update profile'], 400);
        }
        return response()->json(['message' => $customer ], 200);
    }
    public function updatePassword(Request $request)
    {

        if(!$request->has('old_password')){
            return response()->json(['message' => 'old password required'], 401);
        }
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
        $comparePassword = Hash::check($request->old_password , $customer->password);
//        dd($comparePassword);
        if($comparePassword == false){
            return response()->json(['message' => 'wrong password'], 400);
        }

        $updatePassword  = $customer->update([
            'password'=> Hash::make($request->new_password)
        ]);
        if(!$updatePassword){
            return response()->json(['message' => 'failed to update password'], 400);
        }
        return response()->json(['message' => $updatePassword], 200);
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
