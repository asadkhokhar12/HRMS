<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ZKtecoController;
use App\Http\Controllers\ValidationMessageController;
use App\Http\Controllers\ExpireNotificationController;
use App\Http\Controllers\Frontend\NavigatorController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Auth::routes(['login' => false]);
Route::get('zkteco', [ZKtecoController::class, 'zkteco']);
Route::get('getUser', [ZKtecoController::class, 'getUser']);
Route::get('process', [ZKtecoController::class, 'storeAttendance']);
Route::get('login', [LoginController::class, 'test']);

Route::get('face-register', function(){
    return view('backend.employee.face_register');
});

// Route::get('face-attendance', function(){
//     return view('face_attendance');
// });


Route::get('tt',function(){
    return User::find(1)->all_shifts;
});

Route::middleware(['demo.mode'])->group(function () {

    if (!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas' && isModuleActive('Saas') ) {
        $middleware = [
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class,
        ];
    } else {
        $middleware = ['web'];
    }

// send-expire-notification
    Route::get('send-expire-notification', [ExpireNotificationController::class, 'index'])->name('send-expire-notification')->middleware('xss');
    Route::get('notification-read/{id}/{employee_id}', [ExpireNotificationController::class, 'notificationRead'])->name('notification-read')->middleware('xss');
    Route::get('get-all-employee-list-api', [ExpireNotificationController::class, 'getAllEmployeeListApi']);

    Route::get('/storage-link', function () {
        $exitCode = Artisan::call('storage:link');
        return 'storage-linked Successfully';
    })->middleware('xss');

    Route::get('update-features', function () {
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        return 'Database Updated';
    });

    Route::middleware($middleware)->group(
        function () {
            Route::get('/storage-link', function () {
                $exitCode = Artisan::call('storage:link');
                return 'storage-linked Successfully';
            })->middleware('xss');

            Route::get('update-features', function () {
                Artisan::call('migrate', [
                    '--force' => true,
                ]);
                return 'Database Updated';
            });

            Route::get('sign-in', [LoginController::class, 'adminLogin'])->name('adminLogin')->middleware('xss');

            // Route::get('central-login', [LoginController::class, 'centralLoginPage'])->name('centralLoginPage')->middleware('xss');
            // Route::post('central-login', [LoginController::class, 'centralLogin'])->name('centralLogin')->middleware('xss');

            Route::group(['prefix' => 'video-conference'], function () {
                Route::get('my-meeting', [\Modules\VideoConference\Http\Controllers\ConferenceController::class, 'myMeeting']);
            });
            Auth::routes();
            //admin routes here
            include_route_files(__DIR__ . '/admin/');

            //frontend routes here
            include_route_files(__DIR__ . '/frontend/');

            //====================Validation Message Generate===============================
            Route::get('validation-message-generate', function () {
                return view('validation-message-generate');
            })->name('test')->middleware('xss');
            Route::POST('validation-message-generate', [ValidationMessageController::class, 'messageGenerate'])->name('message_generate')->middleware('xss');

            Route::get('sync-flugs/{language_name}', [DevController::class, 'syncFlug']);
        }
    );
});
