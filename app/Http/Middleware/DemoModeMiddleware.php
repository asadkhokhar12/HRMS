<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;

class DemoModeMiddleware
{

    public function handle($request, Closure $next)
    {
        if (config('app.style') === 'demo') {
            // Check the current route action
            $routeAction = $request->route()->getAction('controller');

            // Check if the action is "destroy"
            $action = last(explode('@', $routeAction));

            if ($action === 'destroy' && !$this->isExempt($action)) {
                if ($request->ajax()) {
                    return response()->json([
                        'result' => false,
                        'message' => 'You are not allowed to perform the delete action in demo mode',
                        'error' => 'failed',
                    ], 401);
                } else {
                    Toastr::error(_trans('message.You are not allowed to perform the delete action in demo mode'), 'Error');
                    return redirect()->back();
                }
            }
        }

        return $next($request);
    }

    protected function isExempt($action)
    {
        // Add logic to check if the current model is exempt based on its name
        return in_array($action, $this->exemptModels);
    }
}
