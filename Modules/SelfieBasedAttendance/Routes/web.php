<?php

use Illuminate\Support\Facades\Route;
use Modules\SelfieBasedAttendance\Http\Controllers\SelfieBasedAttendanceController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


if (!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas' && isModuleActive('Saas') ) {
    $middleware = [
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ];
} else {
    $middleware = ['web'];
}


Route::middleware($middleware)->group(function () {
    Route::group([], function () {
        Route::resource('selfiebasedattendance', SelfieBasedAttendanceController::class)->names('selfiebasedattendance');
    });
});
