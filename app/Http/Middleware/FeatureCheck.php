<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Schema;

class FeatureCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature)
    {
        if (config('app.mood') != 'Saas' || !isModuleActive('Saas')) {
            return $next($request);
        }

        if(isMainCompany() && config('app.mood') == 'Saas' && isModuleActive('Saas')) {
            return $next($request);
        }

        if (
            !isMainCompany() && 
            config('app.mood') == 'Saas' && 
            isModuleActive('Saas') && 
            checkSingleCompanyIsDeactivated()
        ) {
            return redirect()->route('single-company.deactivated');
        }

        if (auth()->check() && in_array($feature, activeSubscriptionFeatures())) {
            return $next($request);
        }
            
        return abort(403, 'Access Denied');
    }
}
