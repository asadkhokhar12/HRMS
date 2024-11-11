<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\OfflineBasedAttendance\Http\Controllers\OfflineBasedAttendanceController;

if (!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas'  && isModuleActive('Saas')) {

    $middleware = [
        'api', 'cors', 'TimeZone', 'MaintenanceMode',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ];
} else {
    $middleware = ['api', 'cors', 'TimeZone', 'MaintenanceMode'];
}

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('offlinebasedattendance', fn (Request $request) => $request->user())->name('offlinebasedattendance');
// });

Route::middleware($middleware)->group(function () {
    Route::group(['prefix' => 'V11'], function () {
        Route::group(['middleware' => ['auth:sanctum', 'cors']], function () {
            Route::group(['prefix' => 'user/attendance'], function () {
                // for checkin & checkout
                Route::post('/offline', [OfflineBasedAttendanceController::class, 'manageAttendanceOffline']);
            });
        });
    });
});