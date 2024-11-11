<?php
use Illuminate\Support\Facades\Route;
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
        Route::middleware(['xss', 'TimeZone', 'MaintenanceMode', 'admin', 'FeatureCheck:add_ons'])->group(function () {
            Route::prefix('documents')->group(function () {
                Route::get('/list', 'UserDocumentController@index')->name('documents.index')->middleware('PermissionCheck:employee_document_read');
                Route::get('/document-tbody', 'UserDocumentController@documentTbody')->name('documents.tbody');
                Route::post('/user-documents', 'UserDocumentController@store')->name('documents.store');

                Route::get('/types', 'UserDocumentController@types')->name('documents.types.index')->middleware('PermissionCheck:employee_document_type_read');
                Route::get('types/edit/{id}', 'UserDocumentController@typeEdit')->name('documents.types.edit')->middleware('PermissionCheck:employee_document_type_update');
                Route::get('types/delete/{id}', 'UserDocumentController@typeDelete')->name('documents.types.delete')->middleware('PermissionCheck:employee_document_type_delete');
                Route::get('types/create', 'UserDocumentController@typeCreate')->name('documents.types.create')->middleware('PermissionCheck:employee_document_type_create');
                Route::post('types/store', 'UserDocumentController@typeStore')->name('documents.types.store')->middleware('PermissionCheck:employee_document_type_create');
                Route::any('types/update', 'UserDocumentController@typeUpdate')->name('documents.types.update')->middleware('PermissionCheck:employee_document_type_update');
                Route::get('type-tbody', 'UserDocumentController@typeTbody')->name('documents.types.tbody');

                // routes/web.php or routes/api.php

                Route::get('/user-documents/create', 'UserDocumentController@create')->name('user-documents.create')->middleware('PermissionCheck:employee_document_create');
                Route::get('/user-documents/{id}', 'UserDocumentController@show')->name('user-documents.show')->middleware('PermissionCheck:employee_document_view');
                Route::get('/user-documents/{id}/edit', 'UserDocumentController@edit')->name('user-documents.edit')->middleware('PermissionCheck:employee_document_update');
                Route::put('/user-documents/{id}', 'UserDocumentController@update')->name('user-documents.update')->middleware('PermissionCheck:employee_document_update');
                Route::delete('/user-documents/{id}', 'UserDocumentController@destroy')->name('user-documents.destroy')->middleware('PermissionCheck:employee_document_delete');
            });
        });
    });
});