<?php

use Illuminate\Support\Facades\Route;
use Modules\MultiBranch\Http\Controllers\MultiBranchController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


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
    Route::middleware(['demo.mode'])->group(function () {
        Route::prefix('branches')->group(function () {
            Route::get('/', [MultiBranchController::class, 'index'])->name('branches.index')->middleware('PermissionCheck:branch_read');
            Route::get('create-modal', [MultiBranchController::class, 'createModal'])->name('branch.create_modal')->middleware('PermissionCheck:branch_create');
            Route::post('update/{branch}', [MultiBranchController::class, 'update'])->name('branch.update')->middleware('PermissionCheck:branch_update');

            Route::get('create', [MultiBranchController::class, 'create'])->name('branches.create')->middleware('PermissionCheck:branch_create');
            Route::post('store', [MultiBranchController::class, 'store'])->name('branches.store')->middleware('PermissionCheck:branch_create');
            Route::get('edit/{branch}', [MultiBranchController::class, 'edit'])->name('branches.edit')->middleware('PermissionCheck:branch_update');
            Route::get('delete/{branch}', [MultiBranchController::class, 'destroy'])->name('branches.destroy')->middleware('PermissionCheck:branch_delete');
            Route::post('change-branch', [MultiBranchController::class, 'changeBranch'])->name('branches.ajaxBranchChange')->middleware('PermissionCheck:branch_update');
        });
    });
});