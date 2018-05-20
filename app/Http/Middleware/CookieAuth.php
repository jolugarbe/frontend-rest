<?php

namespace App\Http\Middleware;

use Closure;

class CookieAuth
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
        $token = \Request::cookie('front_us_token', null);
        if($token){
            return $next($request);
        }else{
            return redirect()->to('login')->with('error', 'Necesitas iniciar sesión para acceder a esta página.');
        }

    }
}
