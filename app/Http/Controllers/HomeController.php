<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return view('admin_template');
        return view('welcome');
    }
    public function changeLang($lang)
    {
        if (array_key_exists($lang, [
            'en' => 'english',
            'ar' => 'arabic',
        ])) {
            Session::put('my_locale', $lang);
        }
        return Redirect::back();

    }

}
