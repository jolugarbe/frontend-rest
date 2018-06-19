<?php

namespace App\Http\Middleware;

use Closure;

class RoleAdmin
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
        $token = \Request::cookie('user_admin', null);
        if($token){
            return $next($request);
        }else{
            return redirect()->back()->with('error', 'Necesitas permisos de administrador para acceder a esta página.');
        }
    }
}
