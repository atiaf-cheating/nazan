<?php

namespace App\Http\Controllers\Customer;

use App\Article;
use App\Brand;
use App\Category;
use App\City;
use App\Color;
use App\ColorSize;
use App\Customer;
use App\Favourites;
use App\Gallery;
use App\Merchant;
use App\OrderProduct;
use App\Product;
use App\Review;
use App\Size;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct() {
//        $this->middleware('customerLoggedIn', ['only' => [
//            'addReview','addToFavourites'
//        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $cat_id = 0)
    {
        $settings = DB::table('settings')->where('id',1)->first();
        $favourites =new Collection();
        if(Session::has('customer')){
            $favourites = Favourites::where('user_id',Session::get('customer')->id)->where('deleted_at',null)->get()->pluck('product_id')->unique();
//            dd($favourites);
        }
        $allProducts = Product::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('created_at','DESC')
            ->with('merchant')
            ->with('brand')
            ->with('reviews')
            ->with('category')
//            ->join('merchants','products.merchant_id','=','merchants.id')
            ->paginate(8);
        foreach ($allProducts as $product){
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
        $articles = Article::where('deleted_at',null)
            ->where('active',1)
            ->orderBy('created_at','DESC')
            ->limit(2)
            ->get();
        $categories = Category::where('active',1)
            ->where('deleted_at',null)
            ->where('parent_cat_id',0)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->with('subCategories')
            ->get();
//        dd($categories);
        $gallery = Gallery::orderBy(DB::raw('RAND()'))->take(3)->get();
//        dd($galerry);
        if($categories){
            $allCategories = $categories;
        }else{
            $allCategories = new Collection();
        }
        $bestSellers = OrderProduct::select('product_id')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(*) DESC')
//        ->limit(1)
            ->get();
//        dd($bestSellers);
        if(!$allProducts){
            return view('customer.index',[
                'products'=>[],
                'gallery'=>$gallery,
                'categories'=>$allCategories,
                'articles'=>$articles,
                'bestSellers'=>$bestSellers->pluck('product_id'),
                'settings'=>$settings,
            ]);
        }
        return view('customer.index',[
            'products'=>$allProducts,
            'categories'=>$allCategories,
            'gallery'=>$gallery,
            'articles'=>$articles,
            'bestSellers'=>$bestSellers->pluck('product_id'),
            'settings'=>$settings,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allProducts( $parent_cat_id = 0 ,Request $request){
        //dd($parent_cat_id);
        if(request()->parent_cat_id == null){
            $parent_cat =0;
        }else{
            $parent_cat =  request()->parent_cat_id;
        }
//dd($parent_cat_id);
        $price_from =request()->price_from;
        $price_to =request()->price_to;
//        dd($parent_cat);
        $favourites =new Collection();
        if(Session::has('customer')){
            $favourites = Favourites::where('user_id',Session::get('customer')->id)->where('deleted_at',null)->get()->pluck('product_id')->unique();
//            dd($favourites);
        }
        $allProducts= Product::where('active',1)
            ->where('deleted_at',null)
            ->where('cat_id',$parent_cat)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->orderBy('created_at','DESC')
            ->with('category')
            ->paginate(8);
        //dd($allProducts);
        if(count($allProducts) >0){
            foreach ($allProducts as $product){
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
        }

//       dd($allProducts);

        // if(!$allProducts){
        //     return view('customer.products.index',[
        //         'products'=>[],
        //         'parent_cat'=>$parent_cat,
        //         'price_from'=>$request->price_from,
        //         'price_to'=>$request->price_to,
        //     ]);
        // }
        $categories = Category::where('active',1)
            ->where('deleted_at',null)
            ->where('parent_cat_id',0)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->with('subCategories')
            ->get();
//        dd($categories);
        $gallery = Gallery::orderBy(DB::raw('RAND()'))->take(3)->get();
//        dd($galerry);
        if($categories){
            $allCategories = $categories;
        }else{
            $allCategories = new Collection();
        }
        $articles = Article::where('deleted_at',null)
            ->where('active',1)
            ->orderBy('created_at','DESC')
            ->limit(2)
            ->get();

        return view('customer.products.index',[
            'products'=>$allProducts,
            'categories'=>$allCategories,
            'gallery'=>$allCategories,
            'articles'=>$articles,
            'parent_cat'=>$parent_cat,
            'price_from'=>$request->price_from,
            'price_to'=>$request->price_to,
        ]);
    }

    public function aboutUs(){
        $about = DB::table('about_us')->find(1);
        return view('customer.aboutus',['about'=>$about]);
    }
    public function contactUs(){
        $info = DB::table('settings')->find(1);
        return view('customer.contact',['info'=>$info]);
    }
    public function policy(){
        $policy = DB::table('usage_policy')->find(1);
        return view('customer.policy',['policy'=>$policy]);
    }
    public function create($cat_id = 0)
    {
        $merchants = Merchant::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $brands = Brand::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $colors = Color::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $sizes= Size::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $categories= Category::where('active',1)
            ->where('deleted_at',null)
            ->where('parent_cat_id',0)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
//        dd($sizes);
        return view('products.create',[
            'merchants'=>$merchants
            ,'colors'=>$colors
            ,'sizes'=>$sizes
            ,'categories'=>$categories
            ,'brands'=>$brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'description' => 'required',
//            'cat_id' => 'required|numeric',
            'final_sub_cat' => 'required|numeric',
            'merchant_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        $image = $request->file('image_url');
        $uniqueName = time().'.'.$image->extension();

        $destinationPath = public_path('images/products');

        $image->move($destinationPath, $uniqueName);
        $product= Product::create([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'description' => $request->description,
            'order' => $request->order,
            'cat_id' => $request->final_sub_cat,
            'merchant_id' => $request->merchant_id,
            'brand_id' => $request->brand_id,
            'image_url' => $uniqueName ,
            'active' => 1,
            'created_at' => Carbon::now()
        ]);
//        dd($request->filename);
        if($request->has('filename')){
            $request->validate([
                'filename'=> 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
            ]);
            foreach($request->file('filename') as $image)
            {
                $uniqueName = time().'.'.$image->extension();
                $destinationPath = public_path('images');
                $image->move($destinationPath, $uniqueName);

                $insertAttachments = DB::table('product_attachments')->insert([
                    'product_id'=>$product->id,
                    'attachment_url'=>$uniqueName,
                    'created_at'=>Carbon::now(),
                ]);
            }
        }
        if(!$product){
            Session::flash('message', 'failed to create product');
            return redirect('/products/');
        }
        Session::flash('message', 'product created successfully');
        return redirect('/products/');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
//        dd(Auth::user());
        $favourites =new Collection();
        if(Session::has('customer')){
            $favourites = Favourites::where('user_id',Session::get('customer')->id)->where('deleted_at',null)->get()->pluck('product_id')->unique();
//            dd($favourites);
        }
        $product= Product::where('id',$id)->with('merchant')->first();
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
        $allProductSizes =[];
        foreach ($allColors as $color){
            $sizes = ColorSize::where('color_id',$color->id)
                ->where('deleted_at',null)
                ->where('product_id',$product->id)
                ->with('sizes')->get();
            $color['sizes']=$sizes;
        }

        $product['colors']=$allColors;
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
        $product_images = DB::table('product_attachments')->where('product_id',$product->id)->get();
        if($product_images){
            $image_urls = $product_images->pluck('attachment_url');
            $product['images'] = $image_urls;
        }
//            dd($product);
        if(in_array($product->id,$favourites->toArray())){
            $product['is_favourite']=true;
        }else{
            $product['is_favourite']=false;
        }
//                    dd($product);

        return view('customer.products.show',['product'=>$product]);
    }
    public function addReview(Request $request,$id)
    {
//        dd($request);
        if(Session::has('customer')){
            $customer = Customer::where('id',Session::get('customer')->id)->first();
        }else{
            return redirect()->intended('login/customer');
        }
        $foundRev = Review::where([
            'user_id'=>$customer->id ,
            'product_id'=>$id
        ])->first();
        if($foundRev){
            Session::flash('message', 'You already added Review');
            return redirect('customer/product/details/'.$id);
        }
        $addRev = Review::create([
            'comment'=>$request->comment,
            'user_id'=>$customer->id,
            'review'=>$request->rating,
            'product_id'=>$id,
        ]);
        if(!$addRev){
            Session::flash('message', 'failed to add Review');
            return redirect('customer/product/details/'.$id);
        }
        Session::flash('message', 'Review added successfully');
        return redirect('customer/product/details/'.$id);
    }
    public function addToCart(Request $request)
    {

//        dd(Session::get('cart'));
        if($request->has('quantity')){
            $quantity = $request->quantity;
        }else{
            $quantity = 1;
        }

//        dd(Session::get('cart'));
        $totalPrice = 0;
        $allProductsPrice = 0;
        if(!Session::has('cart') || count(Session::get('cart')->products) == 0){
            $cart = new Collection();
            $cart->products= [];
            $product = [];
            $product['id']=$request->product_id;
            $product['arabic_name']=$request->arabic_name;
            $product['english_name']=$request->english_name;
            $product['description']=$request->description;
            $product['image_url']=$request->image_url;
            $product['cat_id']=$request->cat_id;
            $product['merchant_id']=$request->merchant_id;
            $product['brand_id']=$request->brand_id;
            $product['color_id']=$request->color_id;
            $product['size_id']=$request->size_id;
            $product['price']=$request->price;
            $product['discount']=$request->discount;
            $product['quantity']=$quantity;
            if($request->discount == null){
                $totalPrice += $request->price;
                $cart->totalPrice = $totalPrice *  $quantity;
                $product['priceAfterDiscount']=$request->price ;
                $product['quantityPriceAfterDiscount']=$totalPrice *  $quantity ;
            }else{
                $priceAfterDiscount = $request->price - $request->price*$request->discount/100;
                $totalPrice += $priceAfterDiscount;
                $allQuantityPrice = $totalPrice * $quantity;
                $product['priceAfterDiscount']=$priceAfterDiscount ;
                $product['quantityPriceAfterDiscount']=$priceAfterDiscount *  $quantity ;
                $cart->totalPrice = $allQuantityPrice;
            }
            array_push($cart->products,$product);
            Session::put('cart',$cart);
        }else{
            $product = [];
            $product['id']=$request->product_id;
            $product['arabic_name']=$request->arabic_name;
            $product['english_name']=$request->english_name;
            $product['description']=$request->description;
            $product['image_url']=$request->image_url;
            $product['cat_id']=$request->cat_id;
            $product['merchant_id']=$request->merchant_id;
            $product['brand_id']=$request->brand_id;
            $product['color_id']=$request->color_id;
            $product['size_id']=$request->size_id;
            $product['price']=$request->price;
            $product['discount']=$request->discount;
            $product['quantity']=$quantity;
//            dd(Session::get('cart'));
            $cart = Session::get('cart');
            foreach ($cart->products as $prod){
                //return if product already exists in cart
                if($prod['id'] == $request->product_id){
                    Session::flash('message', 'product already exists');
                    if (strpos(url()->previous(), 'price_filter') == false) {
                        return redirect()->back();
                    }   else {
                        return redirect('customer/products/'.$request->parent_cat);
                    }
                }
            }
            if($product['discount'] == null){
                $totalPrice += $product['price'] * $quantity;
                $cart->totalPrice += $totalPrice;
                $product['priceAfterDiscount']=$request->price ;
                $product['quantityPriceAfterDiscount']=$totalPrice *  $quantity ;
            }else{
                $prodPrice = $product['price'] - $product['price'] * $product['discount']/100;
                $totalPrice = $prodPrice * $quantity;
                $product['priceAfterDiscount']=$prodPrice ;
                $product['quantityPriceAfterDiscount']=$prodPrice *  $quantity ;
                $cart->totalPrice += $totalPrice;
            }
            array_push($cart->products,$product);
            Session::put('cart',$cart);
        }
        Session::flash('message', 'product added successfully');
        if (strpos(url()->previous(), 'price_filter') == false) {
            return redirect()->back();
        }   else {
            return redirect('customer/products/'.$request->parent_cat);
        }
    }
    public function removeFromCart(Request $request ){
        $cart = Session::get('cart');
//        dd($cart);
        $products = $cart->products;
        $cartTotalPrice = $cart->totalPrice;
        $newCartTotalPrice = 0;
        $newProducts = [];
        foreach($products as $product){
            if($product['id'] != $request->product_id){
                array_push($newProducts , $product);
                $newCartTotalPrice += $product['quantityPriceAfterDiscount'];
            }
        }
        Session::forget('cart');
        $cart = new Collection();
        $cart->products= $newProducts;
        Session::put('cart',$cart);
        $cart->totalPrice= $newCartTotalPrice;
        Session::flash('message', 'product removed successfully');
        return redirect()->back();
    }
    public function cartDetails(){
        if(Session::has('cart')){
            $cart = Session::get('cart');
        }else{
            $cart = [];
        }
//        dd($cart);
        return view('customer.cart',['cart'=>$cart]);
    }
    public function getCheckoutForm(){
        if(!Session::has('cart')) {
            return redirect()->back();
        }
        $cart =Session::get('cart');
//        dd(Session::get('cart'));
        $totalPrice = 0;
//        foreach ($cart->products as $product) {
//            if($product->discount == null){
//                $totalPrice += $product->price;
//                $cart->totalPrice = $totalPrice;
//            }else{
//                $priceTotal = $product->price - $product->price*$product->discount/100;
//                $totalPrice += $priceTotal;
//                $cart->totalPrice = $totalPrice;
//            }
//        }

        $cities = City::where('active',1)
            ->where('deleted_at',null)
            ->get();

        return view('customer.checkout',['cities'=>$cities]);
    }

    public function addToFavourites(Request $request , $id=null)
    {
        if(Session::has('customer')){
            $customer = Customer::where('id',Session::get('customer')->id)->first();
        }else{
            return redirect('login/customer');
        }
        $foundFav = Favourites::where([
            'user_id'=>$customer->id,
            'product_id'=>$id,
        ])->first();
        if($foundFav){
            Session::flash('message', 'product already added favourite');
            return redirect('customer/product/details/'.$id);
        }
        $addFav = Favourites::create([
            'user_id'=>$customer->id,
            'product_id'=>$id,
        ]);
        if(!$addFav){
            Session::flash('message', 'failed to add favourite');
            return redirect('customer/product/details/'.$id);
        }
        Session::flash('message', 'product added successfully');
        return redirect()->back();
    }
    public function removeFavourites(Request $request , $id=null)
    {
        if(Session::has('customer')){
            $customer = Customer::where('id',Session::get('customer')->id)->first();
        }
        $addFav = Favourites::where([
            'user_id'=>$customer->id,
            'product_id'=>$id,
        ])->first();
        if(!$addFav){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'failed to remove favourite');
            return redirect('customer/product/details/'.$id);
        }
        $addFav->delete();
        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'product removed successfully');
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $merchants = Merchant::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        $brands = Brand::where('active',1)
            ->where('deleted_at',null)
            ->orderBy('order', 'asc')
            ->orderBy('arabic_name', 'asc')
            ->get();
        return view('products.edit',[
            "product"=>$product,
            "merchants"=>$merchants,
            "brands"=>$brands,
        ]);
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
//        dd($request);
        $request->validate([
            'arabic_name' => 'required',
            'english_name' => 'required',
            'order' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'merchant_id' => 'required|numeric',
        ]);
        $product =Product::findOrFail($id);
        $updated = $product->update([
            'arabic_name' => $request->arabic_name,
            'english_name' => $request->english_name,
            'description' => $request->description,
            'order' => $request->order,
            'cat_id' => $request->cat_id,
            'brand_id' => $request->brand_id,
            'merchant_id' => $request->merchant_id,
            'updated_at' => Carbon::now()
        ]);
        if($request->has('image_url')){
            $image = $request->file('image_url');
            $uniqueName = time().'.'.$image->extension();

            $destinationPath = public_path('images/products');

            $image->move($destinationPath, $uniqueName);

            $product->update([
                'image_url' => $uniqueName ,
            ]);
        }
        if(!$updated){
            Session::flash('message', 'failed to update product');
            return redirect('/products/');
        }
        Session::flash('message', 'product updated successfully');
        return redirect('/products/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $deleted = $product->delete();
        if(!$deleted){
            return Redirect::back()->withErrors(['msg', 'failed to delete product']);
        }
        Session::flash('message', 'product deleted successfully');
        return Redirect::back();
    }

    public function activate($id)
    {
        $product = DB::table('products')->where('id',$id)->update([
            "active"=> 0
        ]);
        if(!$product){
            Session::flash('message', 'failed to deactivate product');
            return redirect('/products');
        }
        Session::flash('message', 'product deactivated successfully');
        return Redirect::back();
    }

    public function getAllSizes(Request $request)
    {
        return true;
        $allSizes = ColorSize::where('color_id',$request->color_id)->with('sizes')->get();
        return response()->json([
            'allSizes'=>$allSizes
        ],200);
    }

}
