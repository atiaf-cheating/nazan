<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'customer')
    {
//        dd($guard);

//        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
//dd('wwwwwww');
//        }
////        dd('ffffffffffffffffffffffffffffffffffff');
//        if ($guard == "customer" && Auth::guard($guard)->check()) {
//            dd('fffffffffffffffffff');
//            return redirect('/pass');
//        }
        if (!Auth::guard('customer')->check()) {
            return redirect('/login/customer');
        }
//        if ($guard == "admin" && Auth::guard($guard)->check()) {
//            return redirect('/admin');
//        }
//        if (Auth::guard($guard)->check()) {
//            return redirect('/pass');
//        }

        return $next($request);

    }
}
