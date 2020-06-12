<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::POST('categories', 'API\CategoriesAPIController@index');
Route::POST('cities', 'API\CitiesAPIController@index');
Route::get('brands', 'API\BrandsAPIController@index');
Route::get('colors', 'API\ColorsAPIController@index');
Route::resource('merchants', 'API\MerchantsAPIController');

Route::POST('products', 'API\ProductAPIController@index');
Route::POST('get_product_by_id', 'API\ProductAPIController@show');

Route::prefix('customer')->group(function () {
    Route::POST('register', 'API\CustomerAPIController@resumeRegistration');
    Route::POST('phone_register', 'API\CustomerAPIController@registerPhone');
    Route::POST('login', 'API\CustomerAPIController@login');
    Route::POST('logout', 'API\CustomerAPIController@logout');
    Route::POST('edit_profile', 'API\CustomerAPIController@editProfile');
    Route::POST('forgot_password', 'API\CustomerAPIController@forgotPassword');
    Route::POST('reset_password', 'API\CustomerAPIController@changePassword');
    Route::POST('change_password', 'API\CustomerAPIController@updatePassword');

});
Route::prefix('favourites')->group(function () {
    Route::POST('all', 'API\FavouritesAPIController@index');
    Route::POST('add', 'API\FavouritesAPIController@create');
    Route::POST('remove', 'API\FavouritesAPIController@destroy');
});
Route::prefix('settings')->group(function () {
    Route::get('about', 'API\SettingsAPIController@aboutUs');
    Route::get('terms', 'API\SettingsAPIController@terms');
    Route::get('info', 'API\SettingsAPIController@settings');
    Route::post('message', 'API\SettingsAPIController@message');
});
Route::prefix('promotions')->group(function () {
    Route::get('all', 'API\PromotionsAPIController@index');
});
Route::post('getDiscountPercentage', 'API\CouponsAPIController@getDiscountPercentage');
Route::post('get_delivery_price', 'API\CouponsAPIController@getDeliveryPriceByCityID');

Route::prefix('orders')->group(function () {
    Route::post('create', 'API\OrderAPIController@create');
    Route::post('get_user_orders', 'API\OrderAPIController@getUserOrders');
});

Route::prefix('reviews')->group(function () {
    Route::post('create', 'API\ProductAPIController@addReview');
    Route::post('get_product_reviews', 'API\ProductAPIController@getProductReviewsByID');
});
