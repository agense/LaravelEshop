<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminUser
{
    /**
     * Handle an incoming request.
     * Only passes if logged in user has admin or superadmin priviledges
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Auth::user()->role === "admin" || Auth::user()->role === "superadmin"){
            return $next($request);
        }else{
            $message = 'This action is not authorized.';
            if($request->wantsJson()) {
                return response()->json(['errors' => ['message' => $message]], 403);
            }
            return redirect()->back()->with('error_message', $message);
        }
    }
}
