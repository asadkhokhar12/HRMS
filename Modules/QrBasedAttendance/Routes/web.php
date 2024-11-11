<?php

use Illuminate\Support\Facades\Route;
use Modules\QrBasedAttendance\Http\Controllers\QrCodeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


if (!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas' && isModuleActive('Saas') ) {
    $middleware = [];

    if (!config('app.single_db')) {
        $middleware = [
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class
        ];
    } else {
        $middleware = [
            'web',
            'check.company.subdomain'
        ];
    }
} else {
    $middleware = ['web'];
}


Route::middleware($middleware)->group(function () {
    Route::group(['prefix' => 'hrm', 'middleware' => ['xss', 'admin', 'MaintenanceMode']], function () {
        Route::controller(QrCodeController::class)->prefix('qr-code')->group(function () {
            Route::any('/', 'qrCode')->name('hrm.qr.index')->middleware('PermissionCheck:generate_qr_code');
        });
    });
});
