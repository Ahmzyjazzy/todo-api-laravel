<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\Model\UserProfile;

class AdminAuth
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
        if (Auth::guard('api')->check() && $request->user() && $request->user()->role_id == 2) {
            return $next($request);            
        } else {
            $message = ["message" => "Permission Denied"];
            return response($message, 401);
        }
    }
}