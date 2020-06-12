<?php

namespace App\Http\Controllers\Customer;

use App\Article;
use App\Color;
use App\ColorSize;
use App\Customer;
use App\Favourites;
use App\Product;
use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(8);
        if(!$customers){
            return view('customers.index',['customers'=>[]]);
        }

        return view('customers.index',[ 'customers'=>$customers]);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
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
    {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blogDetails($id)
    {
        $article = Article::findOrFail($id);
        return view('customer.blog.show',['article'=>$article]);
    }
    public function blogIndex()
    {
        $articles = Article::where('deleted_at',null)
            ->where('active',1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('customer.blog.index',['articles'=>$articles]);
    }
    public function addToFavourites($id){

    }
    public function sendMessage(Request $request){
//        dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'category' => 'required',
        ]);
        $sendMessage =  DB::table('mail_inboxes')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'category' => $request->category,
            'created_at'=>Carbon::now()
        ]);
        if(!$sendMessage){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'failed to send message');
            return redirect('customer/contact_us');
        }
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'message sent successfully');
        return redirect('customer/contact_us');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {
        if(Session::has('customer')){
            $customer = Customer::find(Session::get('customer'));
//            dd($customer);
            return view('customer.profile',['customer'=>$customer]);
        }
        return redirect('login/customer');
    }
    public function getAllFavourites(Request $request){
        $customer =Session::get('customer');
//        dd($customer);
        if(!$customer){
            return redirect('login/customer');
        }
        $favourites = Favourites::where('user_id',$customer['id'])->where('deleted_at',null)->get()->pluck('product_id')->unique();
        $products = Product::whereIn('id',$favourites)
            ->with('merchant')
            ->with('brand')
            ->with('reviews')
            ->with('category')
            ->get();
//            dd($products);
        foreach ($products as $product){
            $reviews = Review::where('product_id', $product->id)->where('deleted_at',null)->with('customer')->get();
//                dd($favourites);
            $reviewsValues = $reviews->pluck('review');
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
            $product['reviews']=$reviews;
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
//                ->with('sizes.sizes')
                ->get();
            foreach ($allColors as $color){
                $sizes = ColorSize::where('color_id',$color->id)
                    ->where('product_id',$product->id)
                    ->get();
                $color['sizes']=$sizes;
            }
            $product['colors']=$allColors;
//                dd($favourites);
            if(in_array($product->id,$favourites->toArray())){
                $product['is_favourite']=true;
            }else{
                $product['is_favourite']=false;
            }
        }
        return view('customer.favourites',['products'=>$products]);
    }
    public function editProfile(Request $request)
    {
//        dd($request);
        $customer = Customer::find($request->id);
        if(!$customer){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'User not found');
            return redirect()->back();
        }
//        dd($customer);
        $updated = $customer->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
        ]);
        if(!$updated){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Error saving changes');
            return redirect()->back();
        }
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'changes saves successfully');
        return redirect()->back()->with(['customer'=>$customer]);
    }
    public function changePassword(){
        return view('customer.change_password');
    }

    public function confirmCode(Request $request){
//        dd($request);

        $request->validate([
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        return view('customer.confirm_code',['pass'=>$request->password]);
    }
    public function updatePassword(Request $request){
//        dd($request);
        $request->validate([
            'password' => 'required',
//            'seg1' => 'required|digits:1',
//            'seg2' => 'required|digits:2',
//            'seg3' => 'required|digits:3',
//            'seg4' => 'required|digits:4'
        ]);
        $customer = Session::get('customer');
        $updateCustomer = Customer::where('id',$customer->id)->update([
            'password' => Hash::make($request->password)
        ]);
//        if(!$updateCustomer){
//            Session::flash('message', 'error');
//            return redirect('change_password',['pass'=>$request->password]);
//        }
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Password Changed Successfully');
        return redirect('customer/profile');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        $request->validate([
//            'arabic_name' => 'required',
//            'english_name' => 'required',
////            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
//            'order' => 'required|numeric',
//        ]);
//        $category=Category::findOrFail($id);
//        $updated = $category->update([
//            'arabic_name' => $request->arabic_name,
//            'english_name' => $request->english_name,
//            'order' => $request->order,
//            'updated_at' => Carbon::now()
//        ]);
//        $image = $request->file('image_url');
//        if($image){
//            $request->validate([
//                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
//            ]);
//            $uniqueName = time().'.'.$image->extension();
//
//            $destinationPath = public_path('images');
//
//            $image->move($destinationPath, $uniqueName);
//
//            $category->update([
//                'image_url' => $uniqueName ,
//            ]);
//        }
//        if(!$updated){
//            Session::flash('message', 'failed to update category');
//            return redirect('/categories');
//        }
//        Session::flash('message', 'category updated successfully');
//        return redirect('/categories');
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $category = Category::findOrFail($id);
//        $deleted = $category->delete();
//        if(!$deleted){
//            return Redirect::back()->withErrors(['msg', 'failed to delete category']);
//        }
//        Session::flash('message', 'category deleted successfully');
//        return Redirect::back();
    }
    public function activate($id)
    {
        $customer = Customer::where('id',$id)->first();
        if($customer->active == 0){
            $updateCustomer = $customer->update([
                "active"=> 1
            ]);
            Session::flash('message', 'customer activated successfully');
            return Redirect::back();
        }else{
            $updateCustomer = $customer->update([
                "active"=> 0
            ]);
            Session::flash('message', 'customer deactivated successfully');
            return Redirect::back();
        }

        if(!$category){
            Session::flash('message', 'failed to deactivate customer');
            return redirect('/customers');
        }

    }
}
