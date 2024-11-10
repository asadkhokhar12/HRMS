<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Policy\PolicyController;

Route::get('/pages/{slug}', [PolicyController::class, 'pagesContent'])->name('pages.content');
Route::get('privacy-policy', [PolicyController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('terms-and-conditions', [PolicyController::class, 'termsAndConditions'])->name('termsAndConditions');
Route::get('support-24-7', [PolicyController::class, 'supportTwentyFour'])->name('supportTwentyFour');


