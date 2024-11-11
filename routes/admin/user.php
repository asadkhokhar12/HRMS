<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\Task\TaskController;
use App\Http\Controllers\Backend\Award\AwardController;
use App\Http\Controllers\Backend\Visit\VisitController;
use App\Http\Controllers\Backend\Notice\NoticeController;
use App\Http\Controllers\Backend\Travel\TravelController;
use App\Http\Controllers\Backend\Payroll\SalaryController;
use App\Http\Controllers\Backend\Payroll\AdvanceController;
use App\Http\Controllers\Backend\Request\RequestController;
use App\Http\Controllers\Backend\Support\SupportController;
use App\Http\Controllers\Backend\Employee\EmployeeController;
use App\Http\Controllers\Backend\Leave\LeaveRequestController;
use App\Http\Controllers\Backend\Management\ProjectController;
use App\Http\Controllers\Backend\Payroll\SalarySetUpController;
use App\Http\Controllers\Backend\Employee\AppointmentController;
use App\Http\Controllers\Backend\Attendance\AttendanceController;
use App\Http\Controllers\Api\Core\Settings\ProfileUpdateSettingController;

Route::group(['middleware' => ['xss', 'TimeZone'], 'prefix' => 'dashboard'], function () {
    // user list
    Route::group(['middleware' => ['admin'], 'prefix' => 'user'], function () {

        Route::middleware(['FeatureCheck:employees'])->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('PermissionCheck:user_read');
            Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware('PermissionCheck:user_create');
            Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware('PermissionCheck:user_create');
            Route::get('show/{user}/{slug}', [UserController::class, 'profileView'])->name('user.profile')->middleware('PermissionCheck:user_read');
            Route::get('edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('PermissionCheck:user_update');
            Route::patch('update/{user}', [UserController::class, 'update'])->name('user.update')->middleware('PermissionCheck:user_update');
            Route::get('permission/{id}', [UserController::class, 'permissionEdit'])->name('user.permission_edit.profile')->middleware('PermissionCheck:user_permission');
            Route::patch('permission/update/{user}', [UserController::class, 'permissionUpdate'])->name('user.permission_update')->middleware('PermissionCheck:user_update');
            Route::get('/sned-reset-mail/{id}', [UserController::class, 'sendResetMail'])->name('user.sendResetMail')->middleware('PermissionCheck:user_read');
            Route::get('make-hr/{user_id}', [UserController::class, 'makeHR'])->name('user.make_hr');
            Route::get('delete/{user}', [UserController::class, 'delete'])->name('user.delete')->middleware('PermissionCheck:user_delete');
            Route::get('change-status/{user}/{status}', [UserController::class, 'changeStatus'])->name('user.changeStatus')->middleware('PermissionCheck:user_update');
            Route::post('delete-data', [UserController::class, 'deleteData'])->name('user.delete_data')->middleware('PermissionCheck:user_update');
            Route::post('status-change', [UserController::class, 'statusUpdate'])->name('user.statusUpdate')->middleware('PermissionCheck:leave_type_update');

        });

        Route::middleware(['FeatureCheck:leaves'])->group(function () {
            Route::get('/leave-balance', [UserController::class, 'leaveBalance'])->name('leaveRequest.balance')->middleware('PermissionCheck:user_read');
            Route::get('/leave-balance/{user}', [UserController::class, 'leaveBalanceEdit'])->name('leaveRequest.balance.edit')->middleware('PermissionCheck:user_read');
            Route::post('/leave-balance/{id}', [UserController::class, 'leaveBalanceUpdate'])->name('leaveRequest.balance.update')->middleware('PermissionCheck:user_read');
        });
        // Route::get('data-table',                    [UserController::class, 'data_table'])->name('user.data_table')->middleware('PermissionCheck:user_read');


        // passport::call - 1
        Route::post('update/{user}/{slug}', [UserController::class, 'profileUpdate'])->name('user.update.profile')->middleware('PermissionCheck:user_update');

       

       

        Route::any('document/request/store', [UserController::class, 'documentRequestStore'])->name('document.request.store');
        Route::get('document/request/approve/{id}', [UserController::class, 'documentRequestApproved'])->name('document.request.approve');


        Route::get('show/{id}', [UserController::class, 'show'])->name('user.show')->middleware('PermissionCheck:user_read');
        Route::get('edit/{user}/{slug}', [UserController::class, 'profileEditView'])->name('user.edit.profile')->middleware('PermissionCheck:user_read');
        
        // salary set up
        Route::get('setup/{user}/{slug}', [UserController::class, 'profileSetUp'])->name('user.edit.profile_setup')->middleware('PermissionCheck:view_payroll_set');
        // salary set up
        

        Route::middleware(['FeatureCheck:support'])->group(function () {
            Route::get('{id}/support', [UserController::class, 'support'])->name('user.support');
            Route::get('supportTickets', [UserController::class, 'supportTicketsDataTable'])->name('user.supportTickets');
        });

        Route::any('{id}/attendance', [UserController::class, 'attendance'])->name('user.attendance');
        Route::get('{id}/expense', [UserController::class, 'expense'])->name('user.expense');
        Route::get('attendanceTable/{id}', [UserController::class, 'attendanceListDataTable'])->name('user.attendanceTable');
        //Leave
        Route::get('{id}/leave-request', [UserController::class, 'leaveRequest'])->name('user.leaveRequest');
        Route::get('{id}/leave-request-approved', [UserController::class, 'leaveRequestApproved'])->name('user.leaveRequestApproved');


        //Notice
        Route::get('{id}/notice', [UserController::class, 'notice'])->name('user.notice');
        Route::get('notice-datatable', [UserController::class, 'noticeDatatable'])->name('user.noticeDatatable');
        Route::get('notice/clear', [UserController::class, 'clearNotice'])->name('user.clearNotice');
        //Phonebook.

        //start auth user profile
        Route::get('profile/{type}', [UserController::class, 'profile'])->name('staff.profile');
        Route::get('edit-profile/{type}', [UserController::class, 'staffProfileEditView'])->name('staff.staffProfileEditView');
        Route::get('/{type}', [UserController::class, 'staffInfo'])->name('staff.profile.info');
        Route::get('/profile/{user_id}/{type}', [UserController::class, 'userInfo'])->name('userProfile.info');
        Route::get('datatable/{user_id}/{type}', [UserController::class, 'userDataTable'])->name('user.profileDataTable');

        // data table for user profile
        Route::group(['prefix' => 'auth-user'], function () {
            Route::get('datatable/{type}', [UserController::class, 'authUserDataTable'])->name('staff.authUserTable');
        });
        //end auth user profile

        Route::middleware(['FeatureCheck:appointment'])->group(function () {
            //Appointment
            Route::get('{id}/appointment', [UserController::class, 'appointment'])->name('user.appointment');
        });

        Route::get('{id}/advance-loan', [AdvanceController::class, 'advanceLoan'])->name('user.advanceLoan');

        //start user profile table

    });
    Route::group(['prefix' => 'auth-user'], function () {
        Route::get('phonebook-table', [UserController::class, 'newPhonebookDatatable'])->name('user.phonebookTable')->middleware('PermissionCheck:phonebook_profile');
        Route::get('support-ticket-table', [SupportController::class, 'userProfileTable'])->name('supportTicket.user_table')->middleware('PermissionCheck:support_ticket_profile');
        Route::get('advance-table', [AdvanceController::class, 'userProfileTable'])->name('advance.auth_user_profile_table')->middleware('PermissionCheck:advance_profile');
        Route::get('commission-table/{user_id}', [SalarySetUpController::class, 'userProfileTable'])->name('commission.auth_user_profile_table')->middleware('PermissionCheck:commission_profile');
        Route::get('salary-table/{user_id}', [SalaryController::class, 'userProfileTable'])->name('salary.auth_user_profile_table');
        Route::get('project-table', [ProjectController::class, 'userProfileTable'])->name('project.auth_user_profile_table')->middleware('PermissionCheck:project_profile');
        Route::get('task-table', [TaskController::class, 'userProfileTable'])->name('task.auth_user_profile_table')->middleware('PermissionCheck:task_profile');
        Route::get('award-table', [AwardController::class, 'userProfileTable'])->name('award.auth_user_profile_table')->middleware('PermissionCheck:award_profile');
        Route::get('travel-table', [TravelController::class, 'userProfileTable'])->name('travel.auth_user_profile_table')->middleware('PermissionCheck:travel_profile');
        Route::get('attendance-table', [AttendanceController::class, 'userProfileTable'])->name('attendance.auth_user_profile_table')->middleware('PermissionCheck:attendance_profile');
        Route::middleware(['FeatureCheck:appointment'])->group(function () {
            Route::get('appointment-table', [AppointmentController::class, 'userProfileTable'])->name('appointment.auth_user_profile_table')->middleware('PermissionCheck:appointment_profile');
        });
        
        Route::middleware(['FeatureCheck:visit'])->group(function () {
            Route::get('visit-table', [VisitController::class, 'userProfileTable'])->name('visit.auth_user_profile_table')->middleware('PermissionCheck:visit_profile');
        });

        Route::get('leave_request-table', [LeaveRequestController::class, 'userProfileTable'])->name('leave_request.auth_user_profile_table')->middleware('PermissionCheck:leave_request_profile');
        Route::get('notice-table', [NoticeController::class, 'userProfileTable'])->name('notice.auth_user_profile_table')->middleware('PermissionCheck:notice_profile');

        //request::call 3
        Route::get('request-table', [RequestController::class, 'userProfileTable'])->name('request.auth_user_profile_table');
    });

    Route::group(['prefix' => 'user'], function () {
        // Route::post('get-users', [UserController::class, 'getUsers'])->name('user.getUser');
        Route::post('get-users', [UserController::class, 'getActiveUsers'])->name('user.getUser');
        Route::post('get-attendance-method', [UserController::class, 'getAttendanceMethod'])->name('user.getAttendanceMethod');
        Route::post('get-all-user-by-dep-des', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers'])->name('user.getByDeptDesWiseUsers');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/{type}', [UserController::class, 'authProfile'])->name('user.authProfile')->middleware('PermissionCheck:profile_view');
        Route::post('security', [UserController::class, 'webSecurity'])->name('user.authProfile.security')->middleware('PermissionCheck:user_update');
    });

    Route::group(['prefix' => 'file'], function () {
        Route::get('view/{image_id}', [EmployeeController::class, 'fileView'])->name('user.fileView')->middleware('PermissionCheck:profile_image_view');
    });
});

// Route::group(['middleware' => ['xss', 'admin', 'TimeZone'], 'prefix' => 'dashboard/user'], function () {
//     Route::controller(EmployeeController::class)->group(function () {
//         Route::get('details/{user_id}/{}',  'profileDetails')->name('user.profile.details')->middleware('PermissionCheck:user_read');

//     });
// });
