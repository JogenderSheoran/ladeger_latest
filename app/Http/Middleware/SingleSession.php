<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

class SingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            // // If current session id is not same with last_session column
            // if(Auth::user()->session_id != Session::getId())
            // {
            //     // do logout
            //     Auth::logout();

            //     session()->flash('logout', "You are trying to login two device at a time");

            //     // Redirecto login page
            //     return redirect('login')->with('info', 'Insert message here');
            // }
        }
        return $next($request);
    }

    
}
