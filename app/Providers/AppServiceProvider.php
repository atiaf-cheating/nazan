<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $footerCategories = Category::where('deleted_at',null)->where('active',1)->orderBy(DB::raw('RAND()'))->take(3)->get();
        $about_info = DB::table('settings')->where('id',1)->first();
        View::share('about_info', $about_info);
    }
}
