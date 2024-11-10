<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Management
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //if not in array
        // $managements=config('onesttech.managements');
        return $next($request);

        if(!in_array(auth()->user()->id,config('onesttech.managements')))
            return abort(403);

    }
}
