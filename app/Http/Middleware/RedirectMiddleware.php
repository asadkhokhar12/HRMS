<?php

namespace App\Http\Middleware;

use Closure;

class RedirectMiddleware
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
        if (config('app.branch')==="MultiBranch" && isModuleActive("MultiBranch")) {
            return $next($request);
        } else {
            return redirect('sign-in');
        }
    }
}
