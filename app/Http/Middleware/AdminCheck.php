<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        if(!Auth::check()){
            //return redirect('/login');
            return response()->json([
                'msg'=>"You are not allow access"
            ],401);
        }
        $user=Auth::user();
        if($user->role->isAdmin == 0){
            return response()->json([
                'msg'=>"You are not allow access"
            ],401);
        }
        return $next($request);
    }
}
