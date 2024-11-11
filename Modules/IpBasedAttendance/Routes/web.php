<?php

use Illuminate\Support\Facades\Route;
use Modules\IpBasedAttendance\Http\Controllers\IpConfigController;
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
    Route::group(['prefix' => 'hrm', 'middleware' => ['xss','admin', 'MaintenanceMode', 'FeatureCheck:configurations']], function () {
        Route::group(['prefix' => 'ip-whitelist', 'middleware' => 'MaintenanceMode'], function () {
            Route::get('/', [IpConfigController::class, 'index'])->name('ipConfig.index')->middleware('PermissionCheck:ip_read');
            Route::get('create', [IpConfigController::class, 'create'])->name('ipConfig.create')->middleware('PermissionCheck:ip_create');
            Route::post('store', [IpConfigController::class, 'store'])->name('ipConfig.store')->middleware('PermissionCheck:ip_create');
            Route::get('datatable', [IpConfigController::class, 'datatable'])->name('ipConfig.datatable')->middleware('PermissionCheck:ip_read');
            Route::get('edit/{id}', [IpConfigController::class, 'edit'])->name('ipConfig.edit')->middleware('PermissionCheck:ip_update');
            Route::post('update/{id}', [IpConfigController::class, 'update'])->name('ipConfig.update')->middleware('PermissionCheck:ip_update');
            Route::get('delete/{id}', [IpConfigController::class, 'destroy'])->name('ipConfig.destroy')->middleware('PermissionCheck:ip_delete');
            Route::post('status-change', [IpConfigController::class, 'statusUpdate'])->name('ipConfig.statusUpdate')->middleware('PermissionCheck:ip_update');
            Route::post('delete-data', [IpConfigController::class, 'deleteData'])->name('ipConfig.delete_data')->middleware('PermissionCheck:ip_delete');
        });
    });
});