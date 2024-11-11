<?php

use Illuminate\Support\Facades\Route;
use Modules\MultiTheme\Http\Controllers\SettingsController;
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
    Route::group(['prefix' => 'admin/settings', 'middleware' => ['xss', 'auth', 'admin', 'FeatureCheck:settings']], function () {
        Route::post('/app-theme', [SettingsController::class, 'appThemeSetup'])->name('manage.settings.update.appTheme')->middleware('PermissionCheck:storage_settings_update');
    });
});