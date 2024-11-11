<?php

use Illuminate\Support\Facades\Route; 
use Modules\AreaBasedAttendance\Http\Controllers\LocationController;
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
        Route::group(['prefix' => 'location', 'middleware' => 'MaintenanceMode'], function () {
            Route::get('/', [LocationController::class, 'location'])->name('company.settings.location')->middleware('PermissionCheck:company_setup_location');
            Route::get('create', [LocationController::class, 'locationCreate'])->name('company.settings.locationCreate')->middleware('PermissionCheck:location_create');
            Route::post('store', [LocationController::class, 'locationStore'])->name('company.settings.locationStore')->middleware('PermissionCheck:location_create');
            Route::get('datatable', [LocationController::class, 'datatable'])->name('company.settings.locationDatatable')->middleware('PermissionCheck:location_read');
            Route::get('edit/{id}', [LocationController::class, 'edit'])->name('company.settings.locationEdit')->middleware('PermissionCheck:location_edit');
            Route::post('update/{id}', [LocationController::class, 'locationUpdate'])->name('company.settings.locationUpdate')->middleware('PermissionCheck:location_update');
            Route::get('delete/{id}', [LocationController::class, 'locationDestroy'])->name('company.settings.locationDestroy')->middleware('PermissionCheck:location_delete');
            Route::get('location-picker', [LocationController::class, 'locationPicker'])->name('company.settings.locationPicker')->middleware('PermissionCheck:location_create');
            Route::post('status-change', [LocationController::class, 'statusUpdate'])->name('location.statusUpdate')->middleware('PermissionCheck:location_update');
            Route::post('delete-data', [LocationController::class, 'deleteData'])->name('location.delete_data')->middleware('PermissionCheck:location_delete');
        });
    });
});
