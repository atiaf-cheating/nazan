<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        app()->setLocale(app('lang'));
//        $this->app->setLocale(session('my_locale', config('app.locale')));
        if (Session::has('my_locale') AND array_key_exists(Session::get('my_locale'), ['en' => 'english', 'ar' => 'arabic', ])) {
            App::setLocale(Session::get('my_locale'));
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}
