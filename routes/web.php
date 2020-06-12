<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::get('/pass',function(){
    return Hash::make('123456789');
});

//Route::get('/', 'HomeController@index');
Route::get('/', 'Customer\ProductController@index');
//Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/customer', 'Auth\LoginController@showCustomerLoginForm');
Route::get('/logout/customer', 'Auth\LoginController@logoutCustomer');
//Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('customer/register', 'Auth\RegisterController@showCustomerRegisterForm');

//Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/customer', 'Auth\LoginController@customerLogin')->name('customer.login');
//Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/customer', 'Auth\RegisterController@createCustomer')->name('/register/customer');

Route::prefix('customer')->group(function () {
    Route::get('/', 'Customer\ProductController@index');
        Route::get('/home', 'Customer\ProductController@index');
    Route::get('/aboutus', 'Customer\ProductController@aboutUs');
    Route::get('/policy', 'Customer\ProductController@policy');
    Route::get('/contact_us', 'Customer\ProductController@contactUs');
    Route::post('/suggestions', 'Customer\CustomersController@sendMessage');

    Route::get('/blog', 'Customer\CustomersController@blogIndex');
    Route::get('/blog_details/{id}', 'Customer\CustomersController@blogDetails');


    Route::get('/products/{parent_cat_id}', 'Customer\ProductController@allProducts');
    Route::post('/products/{parent_cat_id}/price_filter', 'Customer\ProductController@allProducts');
    Route::get('/products', 'Customer\ProductController@allProducts');
    Route::get('/product/details/{id}', 'Customer\ProductController@show');

    Route::get('/favourites', 'Customer\CustomersController@getAllFavourites');
    Route::get('/product/add_to_favourites/{id}', 'Customer\ProductController@addToFavourites');
    Route::get('/product/remove_favourites/{id}', 'Customer\ProductController@removeFavourites');

    Route::get('/product/add_to_cart/{id}', 'Customer\ProductController@addToCart');
    Route::post('/product/add_review/{id}', 'Customer\ProductController@addReview');

    Route::get('/promotions', 'Customer\PromotionsController@index');
    Route::get('/promotions/{brand_id}', 'Customer\PromotionsController@index');

    Route::post('/add_to_cart', 'Customer\ProductController@addToCart')->name('add_to_cart');
    Route::post('/remove_from_cart', 'Customer\ProductController@removeFromCart');
    Route::get('/cart_details', 'Customer\ProductController@cartDetails');

    Route::get('/profile', 'Customer\CustomersController@getProfile');
    Route::get('/change_password', 'Customer\CustomersController@changePassword');
    Route::get('/confirm_code', 'Customer\CustomersController@confirmCode');
    Route::post('/update_password', 'Customer\CustomersController@updatePassword')->name('update_password');
    Route::post('/edit_profile', 'Customer\CustomersController@editProfile');


    Route::get('/checkout', 'Customer\ProductController@getCheckoutForm');

    Route::get('/orders', 'Customer\OrderController@index');
    Route::post('/order/create', 'Customer\OrderController@create');
    Route::get('/order/details/{id}', 'Customer\OrderController@show');

    Route::post('/getAllSizes',function(){
        dd(request()->all());
    });


});
Route::prefix('merchant/control')->group(function () {
    Route::get('/','MerchantsController@merchantHome');
    Route::post('/login', 'MerchantsController@merchantLogin')->name('merchant.login');
    Route::get('/logout', 'MerchantsController@merchantLogout');



    Route::get('/products/color-size/{product_id}/{cat_id}', 'Merchant\ColorSizePriceController@create');
    Route::post('/products/color-size/store', 'Merchant\ColorSizePriceController@store')->name('product_color_size.store');
    Route::post('/products/color-size/update', 'Merchant\ColorSizePriceController@update')->name('product_color_size.update');
    Route::get('/products', 'Merchant\ProductController@index')->name('merchant.products');
    Route::get('/products/create', 'Merchant\ProductController@create');
    Route::post('/products.store', 'Merchant\ProductController@store')->name('products.store');
    Route::get('/products/edit/{id}', 'Merchant\ProductController@edit');
    Route::post('/products.update/{id}', 'Merchant\ProductController@update')->name('products.update');
    Route::get('/products/delete/{id}', 'Merchant\ProductController@destroy');
    Route::get('/products/activate/{id}', 'Merchant\ProductController@activate');


    Route::get('/color_size/edit/{product_id}/{color_product}/{cat_id}', 'Merchant\ColorSizePriceController@edit');
    Route::get('/color_size/activate/{id}', 'Merchant\ColorSizePriceController@activate');
    Route::get('/color_size/delete/{id}', 'Merchant\ColorSizePriceController@destroy');
    Route::get('/color_size/sizes/{id}', 'Merchant\ColorSizePriceController@showSizes');
    Route::get('/color_size/edit-price-quantity/{id}', 'Merchant\ColorSizePriceController@editPriceAndQuantity');
    Route::post('/color_size/update-price-quantity', 'Merchant\ColorSizePriceController@updatePriceAndQuantity');
    Route::post('/color_size/delete-price-quantity', 'Merchant\ColorSizePriceController@deletePriceAndQuantity');
    Route::post('/color_size/deactivate-price-quantity', 'Merchant\ColorSizePriceController@deactivatePriceAndQuantity');


    Route::get('/orders', 'Merchant\OrderController@index');
    Route::get('/orders/details/{id}', 'Merchant\OrderController@show');
    Route::get('/orders/edit-status/{id}', 'Merchant\OrderController@editStatus');
    Route::post('/orders/update_status/{id}', 'Merchant\OrderController@updateStatus');

});

Route::middleware('auth')->group(function () {
    Route::get('/admin/control', 'CategoriesController@index');
    Route::get('/about_us', function(){
        $aboutus= \App\AboutUs::where('id',1)->first();
        return view('about-us',['aboutus'=>$aboutus]);
    });
    Route::post('/about_us/store', function(){
        $ar_about = request('aboutus-trixFields.arabic_text');
        $closedTag =strpos($ar_about, '</div>');
        $arAboutEditted = substr($ar_about,5,$closedTag-5);

        $en_about = request('aboutus-trixFields.english_text');
        $closedTag =strpos($en_about, '</div>');
        $engAboutEditted = substr($en_about,5,$closedTag-5);

        $aboutus = \App\AboutUs::where('id',1)->update([
            'english_text' =>$engAboutEditted,
            'arabic_text' => $arAboutEditted,
        ]);
        Session::flash('message', 'update successful');
        return redirect()->back()->with('aboutus',$aboutus);
    })->name('about.store');
    Route::get('/policy/show', function(){
        $usagepolicy= \App\UsagePolicy::where('id',1)->first();
        return view('usage-policy',['usagepolicy'=>$usagepolicy]);
    });
    Route::post('/policy/store', function(){
//        dd(request()->all());

        $policy = request('usagepolicy-trixFields.english_text');
        $closedTag =strpos($policy, '</div>');
        $engPolicyEditted = substr($policy,5,$closedTag-5);

        $ar_policy = request('usagepolicy-trixFields.arabic_text');
        $closedTag =strpos($policy, '</div>');
        $arPolicyEditted = substr($ar_policy,5,$closedTag-5);
        $usagepolicy= \App\UsagePolicy::where('id',1)->update([
            'english_text' => $engPolicyEditted,
            'arabic_text' => $arPolicyEditted,
        ]);
        Session::flash('message', 'policy updated successfully');
        return redirect()->back()->with('usagepolicy',$usagepolicy);
    })->name('usagepolicy.store');
    Route::get('/policy', 'CategoriesController@index');
    Route::get('/settings', function(){
        $settings = DB::table('settings')->where('id',1)->first();
        return view('settings',['settings'=>$settings]);
    });
    Route::post('/settings/store', function(){
        $settings = DB::table('settings')->where('id',1)->update([
            'phone'=> request('phone'),
            'email'=> request('email'),
            'facebook_url'=> request('facebook_url'),
            'twitter_url'=> request('twitter_url'),
            'instagram_url'=> request('instagram_url'),
        ]);
        $settings = DB::table('settings')->where('id',1)->first();

        //save data in .env file
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

//        if (count($values) > 0) {
//            foreach ($values as $envKey => $envValue) {
                $facebookLink = $settings->facebook_url;
                $twitterLink = $settings->facebook_url;
                $instagramLink = $settings->facebook_url;
                $googleLink = $settings->facebook_url;
                $youtubeLink = $settings->facebook_url;

//                $nazanSettings = config('nazan.social_links');
        $currency = env('FACEBOOK_LINK');


//        $str .= "\n"; // In case the searched variable is in the last line without \n
//        $keyPosition = strpos($str, "{FACEBOOK_LINK}=");
//        $endOfLinePosition = strpos($str, "\n", $keyPosition);
//        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
//
//        // If key does not exist, add it
//        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
//            $str .= "{$envKey}={$envValue}\n";
//        } else {
//            $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
//        }

//            }
//        }

//        $str = substr($str, 0, -1);
//        if (!file_put_contents($envFile, $str)) return false;
//        return true;

        return view('settings',['settings'=>$settings]);
    })->name('settings.store');
    Route::get('/suggestions', 'MailboxController@index');
    Route::get('/suggestions/show/{id}', 'MailboxController@show');
    Route::get('/suggestions/delete/{id}', 'MailboxController@destroy');
    Route::get('admin', function () {
        return view('admin_template');
    });
    Route::get('/widgets', 'WidgetsController@index');

    Route::get('/articles', 'ArticlesController@index');
    Route::get('/articles/create', 'ArticlesController@create');
    Route::post('/articles.store', 'ArticlesController@store')->name('articles.store');
    Route::get('/articles/edit/{id}', 'ArticlesController@edit');
    Route::post('/articles.update/{id}', 'ArticlesController@update')->name('articles.update');
    Route::get('/articles/delete/{id}', 'ArticlesController@destroy');
    Route::get('/articles/activate/{id}', 'ArticlesController@activate');


    Route::get('/categories', 'CategoriesController@index');
    Route::get('/categories/{id}', 'CategoriesController@index');
    Route::get('/categories/create/{id}', 'CategoriesController@create');
    Route::post('/categories.store', 'CategoriesController@store')->name('categories.store');
    Route::get('/categories/edit/{id}', 'CategoriesController@edit');
    Route::post('/categories.update/{id}', 'CategoriesController@update')->name('categories.update');
    Route::get('/categories/delete/{id}', 'CategoriesController@destroy');
    Route::get('/categories/activate/{id}', 'CategoriesController@activate');

    Route::get('/sub-categories', 'SubCategoryController@index');
    Route::get('/sub-categories/create', 'SubCategoryController@create');
    Route::post('/sub-categories.store', 'SubCategoryController@store')->name('sub-categories.store');
    Route::get('/sub-categories/edit/{id}', 'SubCategoryController@edit');
    Route::post('/sub-categories.update/{id}', 'SubCategoryController@update')->name('sub-categories.update');
    Route::get('/sub-categories/delete/{id}', 'SubCategoryController@destroy');
    Route::get('/sub-categories/activate/{id}', 'SubCategoryController@activate');

    Route::get('/sub-sub-categories', 'SubSubCategoryController@index');
    Route::get('/sub-sub-categories/create', 'SubSubCategoryController@create');
    Route::post('/sub-sub-categories.store', 'SubSubCategoryController@store')->name('sub-sub-categories.store');
    Route::get('/sub-sub-categories/edit/{id}', 'SubSubCategoryController@edit');
    Route::post('/sub-sub-categories.update/{id}', 'SubSubCategoryController@update')->name('sub-sub-categories.update');
    Route::get('/sub-sub-categories/delete/{id}', 'SubSubCategoryController@destroy');
    Route::get('/sub-sub-categories/activate/{id}', 'SubSubCategoryController@activate');

    Route::get('/merchants', 'MerchantsController@index');
    Route::get('/merchants/create', 'MerchantsController@create');
    Route::post('/merchants.store', 'MerchantsController@store')->name('merchants.store');
    Route::get('/merchants/edit/{id}', 'MerchantsController@edit');
    Route::post('/merchants.update/{id}', 'MerchantsController@update')->name('merchants.update');
    Route::get('/merchants/delete/{id}', 'MerchantsController@destroy');
    Route::get('/merchants/activate/{id}', 'MerchantsController@activate');

    Route::get('/brands', 'BrandsController@index');
    Route::get('/brands/create', 'BrandsController@create');
    Route::post('/brands.store', 'BrandsController@store')->name('brands.store');
    Route::get('/brands/edit/{id}', 'BrandsController@edit');
    Route::post('/brands.update/{id}', 'BrandsController@update')->name('brands.update');
    Route::get('/brands/delete/{id}', 'BrandsController@destroy');
    Route::get('/brands/activate/{id}', 'BrandsController@activate');


    Route::get('/cities', 'CitiesController@index');
    Route::get('/cities/create', 'CitiesController@create');
    Route::get('/cities/create/{id}', 'CitiesController@create');
    Route::get('/cities/{id}', 'CitiesController@index');
    Route::post('/cities.store', 'CitiesController@store')->name('cities.store');
    Route::get('/cities/edit/{id}', 'CitiesController@edit');
    Route::post('/cities.update/{id}', 'CitiesController@update')->name('cities.update');
    Route::get('/cities/delete/{id}', 'CitiesController@destroy');
    Route::get('/cities/activate/{id}', 'CitiesController@activate');


    Route::get('/colors', 'ColorsController@index');
    Route::get('/colors/create', 'ColorsController@create');
    Route::post('/colors.store', 'ColorsController@store')->name('colors.store');
    Route::get('/colors/edit/{id}', 'ColorsController@edit');
    Route::post('/colors.update/{id}', 'ColorsController@update')->name('colors.update');
    Route::get('/colors/delete/{id}', 'ColorsController@destroy');
    Route::get('/colors/activate/{id}', 'ColorsController@activate');


//    Route::get('/sizes', 'SizesController@index');
    Route::get('/sizes/{cat_id}', 'SizesController@index');
    Route::get('/sizes/create', 'SizesController@create');
    Route::get('/sizes/create/{cat_id}', 'SizesController@create');
    Route::post('/sizes.store', 'SizesController@store')->name('sizes.store');
    Route::get('/sizes/edit/{id}', 'SizesController@edit');
    Route::post('/sizes.update/{id}', 'SizesController@update')->name('sizes.update');
    Route::get('/sizes/delete/{id}', 'SizesController@destroy');
    Route::get('/sizes/activate/{id}', 'SizesController@activate');

    Route::get('/products', 'ProductController@index');
    Route::get('/products/create', 'ProductController@create');
    Route::post('/products.store', 'ProductController@store')->name('products.store');
    Route::get('/products/edit/{id}', 'ProductController@edit');
    Route::post('/products.update/{id}', 'ProductController@update')->name('products.update');
    Route::get('/products/delete/{id}', 'ProductController@destroy');
    Route::get('/products/activate/{id}', 'ProductController@activate');

    Route::get('/sub-categories', 'CategoriesController@showSubCategories');


    Route::get('/products/color-size/{product_id}/{cat_id}', 'ColorSizePriceController@create');
    Route::post('/products/color-size/store', 'ColorSizePriceController@store')->name('product_color_size.store');
    Route::post('/products/color-size/update', 'ColorSizePriceController@update')->name('product_color_size.update');
    Route::get('/products/color-size/delete/{id}', 'ColorSizePriceController@destroy');
    Route::get('/color_size/edit/{product_id}/{color_product}/{cat_id}', 'ColorSizePriceController@edit');
    Route::get('/color_size/activate/{id}', 'ColorSizePriceController@activate');
    Route::get('/color_size/delete/{id}', 'ColorSizePriceController@destroy');
    Route::get('/color_size/sizes/{id}', 'ColorSizePriceController@showSizes');
    Route::post('/color_size/edit-price-quantity', 'ColorSizePriceController@editPriceAndQuantity');
    Route::post('/color_size/delete-price-quantity', 'ColorSizePriceController@deletePriceAndQuantity');
    Route::post('/color_size/deactivate-price-quantity', 'ColorSizePriceController@deactivatePriceAndQuantity');


    Route::get('customers', 'CustomersController@index');
    Route::get('customer/activate/{id}', 'CustomersController@activate');


    Route::get('/promotions', 'PromotionsController@index');
    Route::get('/promotions/create', 'PromotionsController@create');
    Route::post('/promotions/store', 'PromotionsController@store')->name('promotions.store');
    Route::get('/promotions/edit/{id}', 'PromotionsController@edit');
    Route::post('/promotions/update/{id}', 'PromotionsController@update');
    Route::get('/promotions/delete/{id}', 'PromotionsController@destroy');
    Route::get('/promotions/activate/{id}', 'PromotionsController@activate');

    Route::get('/coupons', 'CouponsController@index');
    Route::get('/coupons/create', 'CouponsController@create');
    Route::post('/coupons/store', 'CouponsController@store')->name('coupons.store');
    Route::get('/coupons/edit/{id}', 'CouponsController@edit');
    Route::post('/coupons/update/{id}', 'CouponsController@update')->name('coupons.update');
    Route::get('/coupons/delete/{id}', 'CouponsController@destroy');
    Route::get('/coupons/activate/{id}', 'CouponsController@activate');

    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/details/{id}', 'OrderController@show');
    Route::get('/orders/edit-status/{id}', 'OrderController@editStatus');
    Route::post('/orders/update_status/{id}', 'OrderController@updateStatus');

    Route::get('/galleries', 'GalleryController@index');
    Route::get('/galleries/create', 'GalleryController@create');
    Route::post('/galleries/store', 'GalleryController@store')->name('galleries.store');
    Route::get('/galleries/edit/{id}', 'GalleryController@edit');
    Route::post('/galleries/update/{id}', 'GalleryController@update')->name('galleries.update');
    Route::get('/galleries/delete/{id}', 'GalleryController@destroy');
    Route::get('/galleries/activate/{id}', 'GalleryController@activate');
});

Auth::routes();
Route::get('/ar/{lang}',function(){
    $lang = request()->lang;
    session(['my_locale' => $lang]);
    return redirect()->back();
})->name('/ar');
Route::get('/en/{lang}','HomeController@changeLang')->name('/en');

Route::get('/facebook',function(){
    $facebook = DB::table('settings')->where('id',1)->first();
    return redirect()->away($facebook->facebook_url);

//    return Redirect::to($facebook->facebook_url);
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    echo "done";
});
Route::get('/home', 'CategoriesController@index');
