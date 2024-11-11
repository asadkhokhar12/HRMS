<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Attendance\ShiftController;
use App\Http\Controllers\Backend\Company\LocationController;
use App\Http\Controllers\coreApp\Setting\IpConfigController;
use App\Http\Controllers\Backend\Attendance\HolidayController;
use App\Http\Controllers\Backend\Attendance\WeekendsController;
use App\Http\Controllers\Backend\Attendance\DutyScheduleController;

Route::group(['prefix' => 'hrm', 'middleware' => ['xss','admin', 'MaintenanceMode', 'FeatureCheck:configurations']], function () {


    //weekend setup start
    Route::group(['prefix' => 'weekend/setup'], function () {
        Route::get('/',                          [WeekendsController::class, 'index'])->name('weekendSetup.index')->middleware('PermissionCheck:weekend_read');
        Route::get('show/{weekend}',             [WeekendsController::class, 'show'])->name('weekendSetup.show')->middleware('PermissionCheck:weekend_read');
        Route::post('update/{id}',                [WeekendsController::class, 'update'])->name('weekendSetup.update')->middleware('PermissionCheck:weekend_update');
    });
    //weekend setup end

    //holiday setup start
    Route::group(['prefix' => 'holiday/setup'], function () {
        Route::get('/',                         [HolidayController::class, 'index'])->name('holidaySetup.index')->middleware('PermissionCheck:holiday_read');
        Route::get('/create',                   [HolidayController::class, 'create'])->name('holidaySetup.create')->middleware('PermissionCheck:holiday_create');
        Route::post('store',                    [HolidayController::class, 'store'])->name('holidaySetup.store')->middleware('PermissionCheck:holiday_create');
        Route::get('show/{holiday}',            [HolidayController::class, 'show'])->name('holidaySetup.show')->middleware('PermissionCheck:holiday_update');
        Route::patch('update/{holiday}',        [HolidayController::class, 'update'])->name('holidaySetup.update')->middleware('PermissionCheck:holiday_update');
        Route::get('delete/{holiday_id}',       [HolidayController::class, 'delete'])->name('holidaySetup.delete')->middleware('PermissionCheck:holiday_delete');

        Route::post('delete-data',              [HolidayController::class, 'deleteData'])->name('holidaySetup.deleteData')->middleware('PermissionCheck:holiday_delete');
    });
    //holiday setup end


    //duty schedule start
    Route::group(['prefix' => 'duty/schedule'], function () {
        Route::get('/',                        [DutyScheduleController::class, 'index'])->name('dutySchedule.index')->middleware('PermissionCheck:schedule_read');
        Route::get('create',                   [DutyScheduleController::class, 'create'])->name('dutySchedule.create')->middleware('PermissionCheck:schedule_create');
        Route::post('store',                   [DutyScheduleController::class, 'store'])->name('dutySchedule.store')->middleware('PermissionCheck:schedule_create');
        Route::get('show/{schedule}',          [DutyScheduleController::class, 'show'])->name('dutySchedule.show')->middleware('PermissionCheck:schedule_update');
        Route::patch('update/{schedule}',      [DutyScheduleController::class, 'update'])->name('dutySchedule.update')->middleware('PermissionCheck:schedule_update');
        Route::get('delete/{schedule}',        [DutyScheduleController::class, 'delete'])->name('dutySchedule.delete')->middleware('PermissionCheck:schedule_delete');
        Route::get('list-data',                [DutyScheduleController::class, 'dutyScheduleDataTable'])->name('dutySchedule.dataTable');


        Route::post('delete-data',              [DutyScheduleController::class, 'deleteData'])->name('dutySchedule.deleteData')->middleware('PermissionCheck:schedule_delete');
    });
    //duty schedule end

    //shift start
    Route::group(['prefix' => 'shift'], function () {
        Route::get('/',                         [ShiftController::class, 'index'])->name('shift.index')->middleware('PermissionCheck:shift_read');
        Route::get('create',                    [ShiftController::class, 'create'])->name('shift.create')->middleware('PermissionCheck:shift_create');
        Route::get('data-table',                [ShiftController::class, 'dataTable'])->name('shift.dataTable')->middleware('PermissionCheck:shift_read');
        Route::post('store',                    [ShiftController::class, 'store'])->name('shift.store')->middleware('PermissionCheck:shift_create');
        Route::get('show/{shift}',              [ShiftController::class, 'show'])->name('shift.show')->middleware('PermissionCheck:shift_read');
        Route::get('edit/{shift}',              [ShiftController::class, 'edit'])->name('shift.edit')->middleware('PermissionCheck:shift_update');
        Route::post('update/{shift}',          [ShiftController::class, 'update'])->name('shift.update')->middleware('PermissionCheck:shift_update');
        Route::get('delete/{shift}',            [ShiftController::class, 'delete'])->name('shift.delete')->middleware('PermissionCheck:shift_delete');

        Route::post('status-change',           [ShiftController::class, 'statusUpdate'])->name('shift.statusUpdate')->middleware('PermissionCheck:shift_update');
        Route::post('delete-data',             [ShiftController::class, 'deleteData'])->name('shift.delete_data')->middleware('PermissionCheck:shift_delete');
    });
});
