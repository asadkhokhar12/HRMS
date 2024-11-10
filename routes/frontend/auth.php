<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Policy\PolicyController;
use App\Http\Controllers\Frontend\Socialite\SocialController;

//admin login route
Route::post('admin-login', [LoginController::class, 'authenticate'])->name('admin.login')->middleware('xss', 'cors');

Route::group(['middleware' => ['xss','MaintenanceMode']], function () {

    // Route::get('sign-up', [SignUpController::class, 'signUp'])->name('user.signup');
    Route::get('auth/redirect/{provider}', [SocialController::class, 'redirectToProvider'])->name('social.login');
    Route::get('callback/{provider}', [SocialController::class, 'handleProviderCallback']);

//reset password
    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.forget');
    Route::post('reset-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');
    Route::get('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('change-password', [ForgotPasswordController::class, 'changePassword'])->name('password.change');
    Route::post('change-admin-password', [ForgotPasswordController::class, 'adminChangePassword'])->name('admin.password.change');

//register routes here
    Route::post('add-phone', [SignUpController::class, 'addPhone'])->name('add.phone');
    Route::post('add-name', [SignUpController::class, 'addName'])->name('add.name');
    Route::post('add-email', [SignUpController::class, 'addEmail'])->name('add.email');
    Route::post('add-company-name', [SignUpController::class, 'addCompanyName'])->name('add.company.name');
    Route::post('add-total-employee', [SignUpController::class, 'addTotalEmployee'])->name('add.addTotalEmployee');
    Route::post('add-business-type', [SignUpController::class, 'addBusinessType'])->name('add.business.type');
    Route::post('add-trade-licence', [SignUpController::class, 'addTradeLicence'])->name('add.TradeLicence');
    Route::post('add-user-finally', [SignUpController::class, 'addUserFinally'])->name('add.TradeLicence');
});
Route::post('get-country', [SignUpController::class, 'getCountry'])->name('add.getCountry')->middleware('xss');

