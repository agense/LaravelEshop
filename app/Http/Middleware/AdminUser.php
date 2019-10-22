<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminUser
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
        // check if logged in user has admin or superadmin priviledges
        if(Auth::user()->role === "admin" || Auth::user()->role === "superadmin"){
            return $next($request);
        }
        return redirect()->back()->with('info_message', 'You do not have permission to perform this action.');
    }
}
