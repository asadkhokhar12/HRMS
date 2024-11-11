<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (Auth::check()) {
            \Illuminate\Support\Facades\App::setLocale(userLocal());
            if (@Auth::user())
            {
                return $next($request);
            } else {
                abort('401');
            }
         } else {
             return redirect('/');
         }
    }
}
