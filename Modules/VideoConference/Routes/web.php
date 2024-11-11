<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\VideoConference\Http\Controllers\ConferenceController;

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
        Route::prefix('video-conference')->middleware('auth')->group(function () {
            Route::middleware(['FeatureCheck:conference'])->group(function () {
                //Conference Route Group
                Route::prefix('conference')->group(function () {
                    Route::get('/', [ConferenceController::class, 'index'])->name('conference.index')->middleware('PermissionCheck:conference_read');
                    Route::get('/get_list', [ConferenceController::class, 'getList'])->name('conference.getList')->middleware('PermissionCheck:conference_read');
                    Route::get('/create', [ConferenceController::class, 'create'])->name('conference.create')->middleware('PermissionCheck:conference_create');
                    Route::post('/create', [ConferenceController::class, 'store'])->name('conference.store')->middleware('PermissionCheck:conference_store');
                    Route::get('/edit/{id}', [ConferenceController::class, 'edit'])->name('conference.edit')->middleware('PermissionCheck:conference_update');
                    Route::post('/update', [ConferenceController::class, 'update'])->name('conference.update')->middleware('PermissionCheck:conference_update');
                    Route::get('/view/{id}', [ConferenceController::class, 'show'])->name('conference.view')->middleware('PermissionCheck:conference_read');
                    Route::get('/delete/{id}', [ConferenceController::class, 'delete'])->name('conference.delete')->middleware('PermissionCheck:conference_delete');
                    Route::get('/join/{id}', [ConferenceController::class, 'join'])->name('conference.join')->middleware('PermissionCheck:conference_join');
                });
            });
        });
    });
});
