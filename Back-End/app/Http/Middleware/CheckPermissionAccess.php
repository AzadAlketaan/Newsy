<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CheckPermissionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next, $permission)
    {
         // if user is visitor || not active || does not have the required permission
        if (auth()->guard('api')->user() == null || auth()->guard('api')->user()->is_active != 1 || !auth()->guard('api')->user()->can($permission))
        {
            if (auth()->guard('api')->user())
            {
                // Check if User Not Active
                if (auth()->guard('api')->user()->is_active != 1)
                {
                    Auth::logout();
                    return response()->json('Your account is not active');
                } // Check Permission access_dashboard
                elseif (!auth()->guard('api')->user()->can($permission) && $permission == "access_dashboard")
                {
                    Auth::logout();
                    return response()->json('You don\'t  have permission to access dashboard');
                }
                elseif (!auth()->guard('api')->user()->can($permission)) return response()->json("Access Denied", 403);
                
            }else return response()->json('unauthenticated');
        }
        
        return $next($request);
    }

}
