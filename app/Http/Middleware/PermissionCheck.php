<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (Auth::check()) {
            $user = Auth::user();


            // Check if the user has the required permission
            if (in_array($permission, is_array($user->permissions) ? $user->permissions : json_decode($user->permissions) ?? [])) {
                return $next($request);
            }

            if(config('app.branch')==="MultiBranch" && isModuleActive("MultiBranch") && $user->is_admin){ 
                return $next($request);
            }
        }

        // If none of the conditions are met, abort with a 403 error
        return abort(403, 'Access Denied');
    }

}
