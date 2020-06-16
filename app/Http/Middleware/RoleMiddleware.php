<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(Auth::check()){
            if(Auth::user()->role == $role){
                return $next($request);
            }else{
                return abort(403);
            }
        }else{
            return redirect('/login');
        }
    }
}
