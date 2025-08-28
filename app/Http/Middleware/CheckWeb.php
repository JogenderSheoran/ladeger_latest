<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckWeb
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
        $response = $next($request);
        //If the status is not approved redirect to login 
        if(Auth::check() && Auth::user()->is_admin == 'id_cutter' && Auth::user()->type=='mobile'){
            Auth::logout();
            return redirect('/login')->with('erro_login', 'Your error text');
        }
        return $response;
    }
}
