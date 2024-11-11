<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Auth\LoginController;

Route::get('/', [LoginController::class, 'adminLogin'])->name('adminLogin')->middleware('xss');