<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Visit\VisitController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Task\TaskApiController;
use App\Http\Controllers\Api\PayslipReportController;
use App\Http\Controllers\Backend\Event\EventController;
use App\Http\Controllers\Api\Leave\DailyLeaveController;
use Modules\Saas\Http\Controllers\SaasCompanyController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Backend\Notice\NoticeController;
use App\Http\Controllers\Api\Leave\LeaveRequestController;
use App\Http\Controllers\Api\Report\BreakReportController;
use App\Http\Controllers\Backend\Company\CompanyController;
use App\Http\Controllers\Backend\Finance\ExpenseController;
use App\Http\Controllers\Backend\Meeting\MeetingController;
use App\Http\Controllers\Api\Auth\FaceRecognitionController;
use App\Http\Controllers\Api\Employee\AppointmentController;
use App\Http\Controllers\Api\Appreciate\AppreciateController;
use App\Http\Controllers\Api\Attendance\AttendanceController;
use App\Http\Controllers\Api\Core\Settings\SettingController;
use App\Http\Controllers\Backend\Firebase\FirebaseController;
use App\Http\Controllers\Backend\Expense\HrmExpenseController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\coreApp\Setting\AppSettingsController;
use Modules\Saas\Http\Controllers\API\MainCompanyAPIController;
use Modules\Saas\Http\Controllers\API\PricingPlanAPIController;
use App\Http\Controllers\Api\Report\Leave\LeaveReportController;
use App\Http\Controllers\Backend\Support\SupportTicketController;
use Modules\VideoConference\Http\Controllers\ConferenceController;
use App\Http\Controllers\Backend\Expense\ExpenseCategoryController;
use App\Http\Controllers\Api\Core\Settings\ProfileUpdateSettingController;
use App\Http\Controllers\Api\ModuleApiController;
use App\Http\Controllers\Api\Report\Attendance\AttendanceReportController;
use Modules\Saas\Http\Controllers\API\TenantCompanyAPIController;
use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

if (!in_array(url('/'), config('tenancy.central_domains')) && config('app.mood') === 'Saas'  && isModuleActive('Saas')) {

    $middleware = [
        'api', 'cors', 'TimeZone', 'MaintenanceMode',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ];

} else {
    $middleware = ['api', 'cors', 'TimeZone', 'MaintenanceMode'];
}



Route::middleware($middleware)->group(
    function () {
        Route::group(['prefix' => 'V11'], function () {
            Route::group(['prefix' => 'company-list'], function () {
                Route::get('/', [AuthController::class, 'companyList'])->name('company-list');
            });


            Route::post('login', [AuthController::class, 'login']);
            Route::post('reset-password', [AuthController::class, 'sendResetLinkEmail']);
            Route::post('change-password', [AuthController::class, 'changePassword']);
            Route::group(['middleware' => ['auth:sanctum', 'cors']], function () {

                // Route::post('/face', [AttendanceController::class, 'registerFaceData'])->name('registerFaceData');


                Route::get('logout', [AuthController::class, 'logout']);
                Route::get('logout-all-devices', [AuthController::class, 'logoutAllDevices']);

                Route::group(['prefix' => 'user'], function () {
                    Route::post('firebase-token', [FirebaseController::class, 'firebaseToken']);
                    // update::ayman 04
                    Route::post('profile/{slug}', [ProfileController::class, 'profile']);
                    Route::post('profile-info', [ProfileController::class, 'profileInfo']);
                    Route::get('details/{id}', [ProfileController::class, 'details']);
                    Route::post('profile-update', [ProfileController::class, 'UserProfileUpdate']);
                    // update::ayman 01
                    Route::post('profile/update/{slug}', [ProfileController::class, 'profileUpdate']);
                    Route::post('password-update', [ProfileController::class, 'passwordUpdate']);
                    Route::post('avatar-update', [ProfileController::class, 'avatarImageUpdate']);
                    Route::get('notification', [ProfileController::class, 'notification']);
                    Route::get('read-notification', [ProfileController::class, 'readNotification']);
                    Route::get('notification/clear', [ProfileController::class, 'notificationClear']);
                    Route::get('search/{keywords?}', [ProfileController::class, 'getUserList']);

                    Route::get('token-alive/{_token}', [ProfileController::class, 'checkTokenIsAlive'])->withoutMiddleware('auth:sanctum');
                    //face recognition
                    Route::post('face-recognition', [FaceRecognitionController::class, 'faceRecognition']);
                    Route::get('get-face-data', [FaceRecognitionController::class, 'getFaceData']);

                    Route::post('face-recognition-update', [FaceRecognitionController::class, 'faceRecognitionUpdate']);
                    Route::post('face-recognition-delete', [FaceRecognitionController::class, 'faceRecognitionDelete']);

                    Route::group(['prefix' => 'leave'], function () {
                        Route::post('summary', [LeaveRequestController::class, 'leaveSummary']);
                        Route::post('available', [LeaveRequestController::class, 'getAvailableLeave']);
                        Route::post('list/view', [LeaveRequestController::class, 'leaveListView']);
                        Route::post('request', [LeaveRequestController::class, 'store']);
                        Route::post('details/{id}', [LeaveRequestController::class, 'leaveDetails']);
                        Route::post('request/edit/{id}', [LeaveRequestController::class, 'leaveDetails']);
                        Route::post('request/update/{id}', [LeaveRequestController::class, 'update']);
                        Route::get('request/cancel/{id}', [LeaveRequestController::class, 'cancelLeaveRequest']);

                        Route::group(['prefix' => 'approval'], function () {
                            Route::post('list/view', [LeaveRequestController::class, 'approvalLeaveList']);
                            Route::get('status-change/{id}/{status}', [LeaveRequestController::class, 'approveOrRejectLeaveRequest']);
                        });

                        //team member leaves
                        Route::group(['prefix' => 'team-member'], function () {
                            Route::post('/', [LeaveRequestController::class, 'teamMemberLeaveList']);
                            Route::get('leave-request-approval/{leave_id}/{status_id}', [LeaveRequestController::class, 'statusChange']);
                        });
                    });
                    Route::group(['prefix' => 'attendance'], function () {
                        
                        Route::post('/', [AttendanceController::class, 'manageAttendance']);

                        Route::post('break-back', [AttendanceController::class, 'breakBackEnd']);
                        
                        Route::post('break-back/list/view', [AttendanceController::class, 'breakBackListView']);
                        Route::post('break-back/{slug}', [AttendanceController::class, 'breakBack']);
                        Route::any('break-status', [AttendanceController::class, 'breakBackHistory']);
                        Route::post('break-history', [AttendanceController::class, 'breakBackHistory']);
                        Route::post('user-break-history', [AttendanceController::class, 'userBreakHistory']);
                        Route::post('get-checkin-checkout-status', [AttendanceController::class, 'checkInCheckoutStatus']);
                        Route::post('check-in', [AttendanceController::class, 'checkIn']);
                        Route::post('qr-status', [AttendanceController::class, 'qrStatus']);
                        Route::post('live-location-store', [AttendanceController::class, 'liveLocationStore']);
                        Route::post('check-out/{attendance_id}', [AttendanceController::class, 'checkOut']);
                        Route::post('late-in-reason/{attendance_id}', [AttendanceController::class, 'lateInOutReason']);
                        Route::post('/attendance-from-device', [AttendanceController::class, 'attendanceFromDevice'])->withoutMiddleware('auth:sanctum');
                    });
                });


                Route::group(['prefix' => 'app'], function () {
                    Route::get('get-all-users/{designation}', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers']);
                    Route::get('get-department', [ProfileUpdateSettingController::class, 'getDepartment']);
                    Route::get('get-designation', [ProfileUpdateSettingController::class, 'getDesignation']);
                    Route::get('get-employment-type', [ProfileUpdateSettingController::class, 'getEmployment']);
                    Route::get('get-blood-group', [ProfileUpdateSettingController::class, 'getBloodGroup']);
                    Route::post('get-users', [ProfileUpdateSettingController::class, 'getUsers'])->name('getUsers');
                    Route::get('base-settings', [AppSettingsController::class, 'baseSettings']);
                    Route::get('home-screen', [AppSettingsController::class, 'homeScreen']);
                    Route::get('new-teammate', [AppSettingsController::class, 'newTeamMate']);
                    Route::get('get-ip-address', [AppSettingsController::class, 'getIpAddress']);
                    Route::get('all-contents/{slug}', [AppSettingsController::class, 'allContents']);
                });

                Route::group(['prefix' => 'expense'], function () {
                    Route::get('category', [ExpenseCategoryController::class, 'getExpenseCategory']);
                    Route::post('list', [HrmExpenseController::class, 'expenseList']);
                    Route::get('single-expense/{expense}', [HrmExpenseController::class, 'show']);
                    Route::post('add', [HrmExpenseController::class, 'store']);
                    Route::post('update/{expense_id}', [HrmExpenseController::class, 'expenseUpdate']);
                    Route::delete('delete/{expense}', [HrmExpenseController::class, 'delete']);
                    Route::post('show/{expense}', [ExpenseCategoryController::class, 'getExpenseCategory']);
                    Route::post('send-claim', [HrmExpenseController::class, 'claimSend']);
                    Route::post('claim-history', [HrmExpenseController::class, 'claimHistory']);
                    Route::post('claim-details/{id}', [HrmExpenseController::class, 'claimDetails']);
                    Route::post('payment-history', [HrmExpenseController::class, 'paymentHistory']);
                });
                Route::post('file-upload', [FileUploadController::class, 'fileUpload']);
                //video conference api
                Route::get('test-con', [ConferenceController::class, 'myMeeting']);
                // Route::group(['prefix' => 'conference'], function () {
                //     Route::get('my-meeting', [ConferenceController::class, 'myMeeting'])->name('myMeeting');
                // });
                Route::group(['prefix' => 'accounts'], function () {

                    Route::group(['prefix' => 'expense'], function () {
                        Route::get('category-list',     [ExpenseController::class, 'CategoryList']);
                        Route::post('add',              [ExpenseController::class, 'UserExpenseStore']);
                        Route::post('list',             [ExpenseController::class, 'UserExpenseList']);
                        Route::get('view/{expense_id}', [ExpenseController::class, 'UserExpenseView']);
                    });
                });
                Route::group(['prefix' => 'conference'], function () {
                    Route::get('my-meeting', [ConferenceController::class, 'myMeeting'])->name('myMeeting');
                    Route::get('join/{id}', [ConferenceController::class, 'joinMeeting'])->name('joinMeeting')->withoutMiddleware('auth:sanctum');
                
                    Route::get('/', [ConferenceController::class, 'conferenceAPIList']);
                    Route::post('create', [ConferenceController::class, 'storeAPI']);
                    Route::get('show/{conference_id}', [ConferenceController::class, 'showAPI']);
                });

                Route::prefix('visit')->group(function () {
                    Route::get('/list', [VisitController::class, 'getVisitList']);
                    Route::post('/history', [VisitController::class, 'getVisitHistory']);
                    Route::post('/create', [VisitController::class, 'createVisit']);
                    Route::get('/show/{visit_id}', [VisitController::class, 'getVisitById']);
                    Route::post('/update', [VisitController::class, 'updateVisit']);
                    Route::post('/image-upload', [VisitController::class, 'uploadImage']);
                    Route::get('/images/{visit_id}', [VisitController::class, 'visitImages']);
                    Route::get('/remove-image/{visit_id}/{image_id}', [VisitController::class, 'removeVisitImage']);
                    Route::post('/change-status', [VisitController::class, 'changeVisitStatus']);
                    Route::post('/create-note', [VisitController::class, 'createNote']);
                    Route::post('/create-schedule', [VisitController::class, 'createSchedule']);
                });

                Route::prefix('appreciate')->group(function () {
                    Route::get('/list', [AppreciateController::class, 'index']);
                    Route::post('/create', [AppreciateController::class, 'store']);
                });

                Route::prefix('dashboard')->group(function () {
                    Route::get('/statistics', [DashboardController::class, 'statistics']);
                });

                Route::group(['prefix' => 'app'], function () {
                    Route::get('get-all-users/{designation}', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers']);
                    Route::get('get-user-data/{id}', [ProfileUpdateSettingController::class, 'getUserData']);
                    Route::get('get-all-employees', [ProfileUpdateSettingController::class, 'getAllUser']);
                    Route::get('get-department', [ProfileUpdateSettingController::class, 'getDepartment']);
                    Route::get('get-designation', [ProfileUpdateSettingController::class, 'getDesignation']);
                    Route::get('get-employment-type', [ProfileUpdateSettingController::class, 'getEmployment']);
                    Route::get('get-blood-group', [ProfileUpdateSettingController::class, 'getBloodGroup']);
                    Route::post('get-users', [ProfileUpdateSettingController::class, 'getUsers'])->name('getUsers');
                    Route::get('base-settings', [AppSettingsController::class, 'baseSettings']);
                    Route::get('home-screen', [AppSettingsController::class, 'homeScreen']);
                    Route::get('new-teammate', [AppSettingsController::class, 'newTeamMate']);
                    Route::get('get-ip-address', [AppSettingsController::class, 'getIpAddress']);
                    Route::get('all-contents/{slug}', [AppSettingsController::class, 'allContents']);

                    // document request api
                    Route::get('get-document-request-list', [AppSettingsController::class, 'getDocumentRequestList']);
                    Route::post('document-request-list/submit', [AppSettingsController::class, 'submitDocumentRequest']);
                });

                Route::group(['prefix' => 'support-ticket'], function () {
                    Route::post('add', [SupportTicketController::class, 'store']);
                    Route::post('list', [SupportTicketController::class, 'listView']);
                    Route::get('show/{id}', [SupportTicketController::class, 'show']);
                });

                Route::group(['prefix' => 'notice'], function () {
                    Route::post('add', [NoticeController::class, 'storeNotice']);
                    Route::post('list', [NoticeController::class, 'listView']);
                    Route::get('show/{id}', [NoticeController::class, 'show']);
                    Route::get('statistics/{id}', [NoticeController::class, 'statistics']);
                    Route::get('clear', [NoticeController::class, 'clear']);
                });

                Route::prefix('appoinment')->group(function () {
                    Route::post('/get-list', [AppointmentController::class, 'index']);
                    Route::get('/details/{id}', [AppointmentController::class, 'getDetails']);
                    Route::post('/create', [AppointmentController::class, 'store']);
                    Route::post('/change-status', [AppointmentController::class, 'appoinmentChangeStatus']);
                    Route::post('/update', [AppointmentController::class, 'update']);
                    Route::get('/delete', [AppointmentController::class, 'delete']);
                });

                Route::prefix('upcoming-events')->group(function () {
                    Route::post('/get-list', [EventController::class, 'index']);
                });

                Route::group(['prefix' => 'meeting'], function () {
                    Route::post('/', [MeetingController::class, 'meetingList']);
                    Route::post('create', [MeetingController::class, 'store']);
                    Route::get('show/{meeting_id}', [MeetingController::class, 'show']);
                    Route::post('add/participants', [MeetingController::class, 'addParticipants']);
                    Route::get('participants/{meeting_id}', [MeetingController::class, 'participants']);
                });

                Route::group(['prefix' => 'report'], function () {
                    //Attendance Report
                    Route::group(['prefix' => 'attendance'], function () {
                        Route::post('particular-month/{user}', [AttendanceReportController::class, 'userMonthlyAttendanceReport']);
                        Route::post('particular-date', [AttendanceReportController::class, 'userDailyAttendanceReport']);
                        Route::post('date-summary', [AttendanceReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                        Route::post('summary-to-list', [AttendanceReportController::class, 'summaryToList'])->middleware('PermissionCheck:attendance_report_read');
                    });
                    //Break Route group
                    Route::group(['prefix' => 'break'], function () {
                        Route::post('date-summary', [BreakReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                        Route::post('user-break-history', [BreakReportController::class, 'userBreakHistory'])->middleware('PermissionCheck:attendance_report_read');
                    });
                    //Leave Route group
                    Route::group(['prefix' => 'leave'], function () {
                        Route::post('date-summary', [LeaveReportController::class, 'dateSummary']);
                        Route::post('date-wise-leave', [LeaveReportController::class, 'dateSummaryList'])->middleware('PermissionCheck:leave_request_read');
                        Route::post('user-wise-list', [LeaveReportController::class, 'dateUserLeaveList'])->middleware('PermissionCheck:leave_request_read');
                    });
                    //Payslip Route group
                    Route::group(['prefix' => 'payslip'], function () {
                        Route::post('list', [PayslipReportController::class, 'getList']);
                        Route::get('show-html/{salary_id}/{user_id}', [PayslipReportController::class, 'showPaySlipHtml'])->name('appPayslip.show.html')->withoutMiddleware('auth:sanctum');
                        Route::get('show/{salary_id}/{user_id}', [PayslipReportController::class, 'showPaySlip'])->name('appPayslip.show')->withoutMiddleware('auth:sanctum');
                    });
                });

                Route::prefix('daily-leave')->group(function () {
                    Route::post('/leave-list', [DailyLeaveController::class, 'monthlySummeryView'])->name('daily-leave.monthlySummeryView');
                    // Route::any('/list', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.list');
                    Route::post('/store', [DailyLeaveController::class, 'store'])->name('daily-leave.store');
                    Route::any('/list', [DailyLeaveController::class, 'listView'])->name('daily-leave.list');
                    Route::post('/staff-list-view', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.staffListView');
                    Route::post('/approve-reject', [DailyLeaveController::class, 'approveRejectLeave'])->name('daily-leave.approveReject');
                    Route::post('/single-view', [DailyLeaveController::class, 'LeaveView'])->name('daily-leave.LeaveView');
                });

                Route::group(['prefix' => 'tasks'], function () {
                    //Route::get('/',                     [TaskApiController::class, 'AppTaskScreen']);
                    Route::get('/',                     [TaskApiController::class, 'AppTaskList']);
                    Route::get('/change-status',        [TaskApiController::class, 'AppTaskChangeStatus']);
                    Route::get('/delete',               [TaskApiController::class, 'AppTaskDelete']);
                    Route::get('/list',                 [TaskApiController::class, 'AppTaskList']);
                    Route::get('/create',               [TaskApiController::class, 'AppTaskCreate']);
                    Route::get('/{task_id}',            [TaskApiController::class, 'AppTaskDetails']);
                    Route::get('/delete/{task_id}',     [TaskApiController::class, 'AppTaskDelete']);
                    Route::post('/store',               [TaskApiController::class, 'AppTaskStore']);
                    Route::post('/update',              [TaskApiController::class, 'AppTaskUpdate']);
                    Route::post('/store-comment',       [TaskApiController::class, 'AppTaskStoreComment']);
                    Route::post('/update-comment',      [TaskApiController::class, 'AppTaskUpdateComment']);
                    Route::get('/delete-comment/{id}',  [TaskApiController::class, 'AppTaskDeleteComment']);
                    Route::post('/like-feedback',       [TaskApiController::class, 'AppTaskLikeFeedback']);
                });

                Route::get('/modules', [ModuleApiController::class, 'modules']);
                Route::get('/check-module-status/{module}', [ModuleApiController::class, 'checkModuleStatus']);
            });
        });


        Route::group(['prefix' => 'saas/main-company'], function () {
            Route::get('basic-info',                                        [MainCompanyAPIController::class, 'basicInfo']);
            Route::get('stripe-token',                                      [MainCompanyAPIController::class, 'stripeToken']);
            Route::get('offline-payment-types',                             [MainCompanyAPIController::class, 'offlinePaymentTypes']);
            Route::get('plan-features',                                     [PricingPlanAPIController::class, 'planFeatures']);
            Route::get('pricing-plans',                                     [PricingPlanAPIController::class, 'pricingPlans']);
            Route::get('pricing-plans-details/{pricing_plan_price_id}',     [PricingPlanAPIController::class, 'pricingPlanDetails']);
            Route::post('upgrade-plan/{subdomain}',                         [PricingPlanAPIController::class, 'upgradePlan']);
        });




        //api 2.0
        Route::group(['prefix' => '3.0'], function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('reset-password', [AuthController::class, 'sendResetLinkEmail']);
            Route::post('change-password', [AuthController::class, 'changePassword']);
            Route::group(['middleware' => ['auth:sanctum', 'cors']], function () {

                Route::get('logout', [AuthController::class, 'logout']);
                Route::get('logout-all-devices', [AuthController::class, 'logoutAllDevices']);

                Route::group(['prefix' => 'user'], function () {
                    Route::post('firebase-token', [FirebaseController::class, 'firebaseToken']);
                    // update::ayman 04
                    Route::post('profile/{slug}', [ProfileController::class, 'profile']);
                    Route::post('profile-info', [ProfileController::class, 'profileInfo']);
                    Route::get('details/{id}', [ProfileController::class, 'details']);
                    Route::post('profile-update', [ProfileController::class, 'UserProfileUpdate']);
                    // update::ayman 01
                    Route::post('profile/update/{slug}', [ProfileController::class, 'profileUpdate']);
                    Route::post('password-update', [ProfileController::class, 'passwordUpdate']);
                    Route::post('avatar-update', [ProfileController::class, 'avatarImageUpdate']);
                    Route::get('notification', [ProfileController::class, 'notification']);
                    Route::get('read-notification', [ProfileController::class, 'readNotification']);
                    Route::get('notification/clear', [ProfileController::class, 'notificationClear']);
                    Route::get('search/{keywords?}', [ProfileController::class, 'getUserList']);

                    Route::get('token-alive/{_token}', [ProfileController::class, 'checkTokenIsAlive'])->withoutMiddleware('auth:sanctum');
                    //face recognition
                    Route::post('face-recognition', [FaceRecognitionController::class, 'faceRecognition']);
                    Route::get('get-face-data', [FaceRecognitionController::class, 'getFaceData']);

                    Route::post('face-recognition-update', [FaceRecognitionController::class, 'faceRecognitionUpdate']);
                    Route::post('face-recognition-delete', [FaceRecognitionController::class, 'faceRecognitionDelete']);

                    Route::group(['prefix' => 'leave'], function () {
                        Route::post('summary', [LeaveRequestController::class, 'leaveSummary']);
                        Route::post('available', [LeaveRequestController::class, 'getAvailableLeave']);
                        Route::post('list/view', [LeaveRequestController::class, 'leaveListView']);
                        Route::post('request', [LeaveRequestController::class, 'store']);
                        Route::post('details/{id}', [LeaveRequestController::class, 'leaveDetails']);
                        Route::post('request/edit/{id}', [LeaveRequestController::class, 'leaveDetails']);
                        Route::post('request/update/{id}', [LeaveRequestController::class, 'update']);
                        Route::get('request/cancel/{id}', [LeaveRequestController::class, 'cancelLeaveRequest']);

                        Route::group(['prefix' => 'approval'], function () {
                            Route::post('list/view', [LeaveRequestController::class, 'approvalLeaveList']);
                            Route::get('status-change/{id}/{status}', [LeaveRequestController::class, 'approveOrRejectLeaveRequest']);
                        });

                        //team member leaves
                        Route::group(['prefix' => 'team-member'], function () {
                            Route::post('/', [LeaveRequestController::class, 'teamMemberLeaveList']);
                            Route::get('leave-request-approval/{leave_id}/{status_id}', [LeaveRequestController::class, 'statusChange']);
                        });
                    });
                    Route::group(['prefix' => 'attendance'], function () {
                        Route::post('break-back/list/view', [AttendanceController::class, 'breakBackListView']);
                        Route::post('break-back/{slug}', [AttendanceController::class, 'breakBack']);
                        Route::any('break-status', [AttendanceController::class, 'breakBackHistory']);
                        Route::post('break-history', [AttendanceController::class, 'breakBackHistory']);
                        Route::post('user-break-history', [AttendanceController::class, 'userBreakHistory']);
                        Route::post('get-checkin-checkout-status', [AttendanceController::class, 'checkInCheckoutStatus']);
                        Route::post('check-in', [AttendanceController::class, 'checkIn']);
                        Route::post('qr-status', [AttendanceController::class, 'qrStatus']);
                        Route::post('live-location-store', [AttendanceController::class, 'liveLocationStore']);
                        Route::patch('check-out/{attendance_id}', [AttendanceController::class, 'checkOut']);
                        Route::post('late-in-reason/{attendance_id}', [AttendanceController::class, 'lateInOutReason']);
                        Route::post('/attendance-from-device', [AttendanceController::class, 'attendanceFromDevice'])->withoutMiddleware('auth:sanctum');

                        
                    });
                });


                Route::group(['prefix' => 'app'], function () {
                    Route::get('get-all-users/{designation}', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers']);
                    Route::get('get-department', [ProfileUpdateSettingController::class, 'getDepartment']);
                    Route::get('get-designation', [ProfileUpdateSettingController::class, 'getDesignation']);
                    Route::get('get-employment-type', [ProfileUpdateSettingController::class, 'getEmployment']);
                    Route::get('get-blood-group', [ProfileUpdateSettingController::class, 'getBloodGroup']);
                    Route::post('get-users', [ProfileUpdateSettingController::class, 'getUsers'])->name('getUsers');
                    Route::get('base-settings', [AppSettingsController::class, 'baseSettings']);
                    Route::get('home-screen', [AppSettingsController::class, 'homeScreen']);
                    Route::get('new-teammate', [AppSettingsController::class, 'newTeamMate']);
                    Route::get('get-ip-address', [AppSettingsController::class, 'getIpAddress']);
                    Route::get('all-contents/{slug}', [AppSettingsController::class, 'allContents']);
                });

                Route::group(['prefix' => 'expense'], function () {
                    Route::get('category', [ExpenseCategoryController::class, 'getExpenseCategory']);
                    Route::post('list', [HrmExpenseController::class, 'expenseList']);
                    Route::get('single-expense/{expense}', [HrmExpenseController::class, 'show']);
                    Route::post('add', [HrmExpenseController::class, 'store']);
                    Route::post('update/{expense_id}', [HrmExpenseController::class, 'expenseUpdate']);
                    Route::delete('delete/{expense}', [HrmExpenseController::class, 'delete']);
                    Route::post('show/{expense}', [ExpenseCategoryController::class, 'getExpenseCategory']);
                    Route::post('send-claim', [HrmExpenseController::class, 'claimSend']);
                    Route::post('claim-history', [HrmExpenseController::class, 'claimHistory']);
                    Route::post('claim-details/{id}', [HrmExpenseController::class, 'claimDetails']);
                    Route::post('payment-history', [HrmExpenseController::class, 'paymentHistory']);
                });
                Route::post('file-upload', [FileUploadController::class, 'fileUpload']);
                //video conference api
                Route::get('test-con', [ConferenceController::class, 'myMeeting']);
                // Route::group(['prefix' => 'conference'], function () {
                //     Route::get('my-meeting', [ConferenceController::class, 'myMeeting'])->name('myMeeting');
                // });
                Route::group(['prefix' => 'accounts'], function () {

                    Route::group(['prefix' => 'expense'], function () {
                        Route::get('category-list',     [ExpenseController::class, 'CategoryList']);
                        Route::post('add',              [ExpenseController::class, 'UserExpenseStore']);
                        Route::post('list',             [ExpenseController::class, 'UserExpenseList']);
                        Route::get('view/{expense_id}', [ExpenseController::class, 'UserExpenseView']);
                    });
                });
                Route::group(['prefix' => 'conference'], function () {
                    Route::get('my-meeting', [ConferenceController::class, 'myMeeting'])->name('myMeeting');
                    Route::get('join/{id}', [ConferenceController::class, 'joinMeeting'])->name('joinMeeting')->withoutMiddleware('auth:sanctum');
                });

                Route::prefix('visit')->group(function () {
                    Route::get('/list', [VisitController::class, 'getVisitList']);
                    Route::post('/history', [VisitController::class, 'getVisitHistory']);
                    Route::post('/create', [VisitController::class, 'createVisit']);
                    Route::get('/show/{visit_id}', [VisitController::class, 'getVisitById']);
                    Route::post('/update', [VisitController::class, 'updateVisit']);
                    Route::post('/image-upload', [VisitController::class, 'uploadImage']);
                    Route::get('/images/{visit_id}', [VisitController::class, 'visitImages']);
                    Route::get('/remove-image/{visit_id}/{image_id}', [VisitController::class, 'removeVisitImage']);
                    Route::post('/change-status', [VisitController::class, 'changeVisitStatus']);
                    Route::post('/create-note', [VisitController::class, 'createNote']);
                    Route::post('/create-schedule', [VisitController::class, 'createSchedule']);
                });

                Route::prefix('appreciate')->group(function () {
                    Route::get('/list', [AppreciateController::class, 'index']);
                    Route::post('/create', [AppreciateController::class, 'store']);
                });

                Route::prefix('dashboard')->group(function () {
                    Route::get('/statistics', [DashboardController::class, 'statistics']);
                });

                Route::group(['prefix' => 'app'], function () {
                    Route::get('get-all-users/{designation}', [ProfileUpdateSettingController::class, 'getDesignationWiseUsers']);
                    Route::get('get-user-data/{id}', [ProfileUpdateSettingController::class, 'getUserData']);
                    Route::get('get-all-employees', [ProfileUpdateSettingController::class, 'getAllUser']);
                    Route::get('get-department', [ProfileUpdateSettingController::class, 'getDepartment']);
                    Route::get('get-designation', [ProfileUpdateSettingController::class, 'getDesignation']);
                    Route::get('get-employment-type', [ProfileUpdateSettingController::class, 'getEmployment']);
                    Route::get('get-blood-group', [ProfileUpdateSettingController::class, 'getBloodGroup']);
                    Route::post('get-users', [ProfileUpdateSettingController::class, 'getUsers'])->name('getUsers');
                    Route::get('base-settings', [AppSettingsController::class, 'baseSettings']);
                    Route::get('home-screen', [AppSettingsController::class, 'homeScreen']);
                    Route::get('new-teammate', [AppSettingsController::class, 'newTeamMate']);
                    Route::get('get-ip-address', [AppSettingsController::class, 'getIpAddress']);
                    Route::get('all-contents/{slug}', [AppSettingsController::class, 'allContents']);

                    // document request api
                    Route::get('get-document-request-list', [AppSettingsController::class, 'getDocumentRequestList']);
                    Route::post('document-request-list/submit', [AppSettingsController::class, 'submitDocumentRequest']);
                });

                Route::group(['prefix' => 'support-ticket'], function () {
                    Route::post('add', [SupportTicketController::class, 'store']);
                    Route::post('list', [SupportTicketController::class, 'listView']);
                    Route::get('show/{id}', [SupportTicketController::class, 'show']);
                });

                Route::group(['prefix' => 'notice'], function () {
                    Route::post('add', [NoticeController::class, 'storeNotice']);
                    Route::post('list', [NoticeController::class, 'listView']);
                    Route::get('show/{id}', [NoticeController::class, 'show']);
                    Route::get('statistics/{id}', [NoticeController::class, 'statistics']);
                    Route::get('clear', [NoticeController::class, 'clear']);
                });

                Route::prefix('appoinment')->group(function () {
                    Route::post('/get-list', [AppointmentController::class, 'index']);
                    Route::get('/details/{id}', [AppointmentController::class, 'getDetails']);
                    Route::post('/create', [AppointmentController::class, 'store']);
                    Route::post('/change-status', [AppointmentController::class, 'appoinmentChangeStatus']);
                    Route::post('/update', [AppointmentController::class, 'update']);
                    Route::get('/delete', [AppointmentController::class, 'delete']);
                });

                Route::prefix('upcoming-events')->group(function () {
                    Route::post('/get-list', [EventController::class, 'index']);
                });

                Route::group(['prefix' => 'meeting'], function () {
                    Route::post('/', [MeetingController::class, 'meetingList']);
                    Route::post('create', [MeetingController::class, 'store']);
                    Route::get('show/{meeting_id}', [MeetingController::class, 'show']);
                    Route::post('add/participants', [MeetingController::class, 'addParticipants']);
                    Route::get('participants/{meeting_id}', [MeetingController::class, 'participants']);
                });

                Route::group(['prefix' => 'report'], function () {
                    //Attendance Report
                    Route::group(['prefix' => 'attendance'], function () {
                        Route::post('particular-month/{user}', [AttendanceReportController::class, 'userMonthlyAttendanceReport']);
                        Route::post('particular-date', [AttendanceReportController::class, 'userDailyAttendanceReport']);
                        Route::post('date-summary', [AttendanceReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                        Route::post('summary-to-list', [AttendanceReportController::class, 'summaryToList'])->middleware('PermissionCheck:attendance_report_read');
                    });
                    //Break Route group
                    Route::group(['prefix' => 'break'], function () {
                        Route::post('date-summary', [BreakReportController::class, 'dateSummary'])->middleware('PermissionCheck:attendance_report_read');
                        Route::post('user-break-history', [BreakReportController::class, 'userBreakHistory'])->middleware('PermissionCheck:attendance_report_read');
                    });
                    //Leave Route group
                    Route::group(['prefix' => 'leave'], function () {
                        Route::post('date-summary', [LeaveReportController::class, 'dateSummary']);
                        Route::post('date-wise-leave', [LeaveReportController::class, 'dateSummaryList'])->middleware('PermissionCheck:leave_request_read');
                        Route::post('user-wise-list', [LeaveReportController::class, 'dateUserLeaveList'])->middleware('PermissionCheck:leave_request_read');
                    });
                    //Payslip Route group
                    Route::group(['prefix' => 'payslip'], function () {
                        Route::post('list', [PayslipReportController::class, 'getList']);
                        Route::get('show-html/{salary_id}/{user_id}', [PayslipReportController::class, 'showPaySlipHtml'])->name('appPayslip.show.html')->withoutMiddleware('auth:sanctum');
                        Route::get('show/{salary_id}/{user_id}', [PayslipReportController::class, 'showPaySlip'])->name('appPayslip.show')->withoutMiddleware('auth:sanctum');
                    });
                });

                Route::prefix('daily-leave')->group(function () {
                    Route::post('/leave-list', [DailyLeaveController::class, 'monthlySummeryView'])->name('daily-leave.monthlySummeryView');
                    // Route::any('/list', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.list');
                    Route::post('/store', [DailyLeaveController::class, 'store'])->name('daily-leave.store');
                    Route::any('/list', [DailyLeaveController::class, 'listView'])->name('daily-leave.list');
                    Route::post('/staff-list-view', [DailyLeaveController::class, 'staffListView'])->name('daily-leave.staffListView');
                    Route::post('/approve-reject', [DailyLeaveController::class, 'approveRejectLeave'])->name('daily-leave.approveReject');
                    Route::post('/single-view', [DailyLeaveController::class, 'LeaveView'])->name('daily-leave.LeaveView');
                });

                Route::group(['prefix' => 'tasks'], function () {
                    Route::get('/',                     [TaskApiController::class, 'AppTaskScreen']);
                    Route::get('/change-status',        [TaskApiController::class, 'AppTaskChangeStatus']);
                    Route::get('/delete',               [TaskApiController::class, 'AppTaskDelete']);
                    Route::get('/list',                 [TaskApiController::class, 'AppTaskList']);
                    Route::get('/create',               [TaskApiController::class, 'AppTaskCreate']);
                    Route::get('/{task_id}',            [TaskApiController::class, 'AppTaskDetails']);
                    Route::get('/delete/{task_id}',     [TaskApiController::class, 'AppTaskDelete']);
                    Route::post('/store',               [TaskApiController::class, 'AppTaskStore']);
                    Route::post('/update',              [TaskApiController::class, 'AppTaskUpdate']);
                    Route::post('/store-comment',       [TaskApiController::class, 'AppTaskStoreComment']);
                    Route::post('/update-comment',      [TaskApiController::class, 'AppTaskUpdateComment']);
                    Route::get('/delete-comment/{id}',  [TaskApiController::class, 'AppTaskDeleteComment']);
                    Route::post('/like-feedback',       [TaskApiController::class, 'AppTaskLikeFeedback']);
                });
            });
        });

        if (class_exists('Modules\Saas\Http\Controllers\API\TenantCompanyAPIController')) {
            Route::prefix('saas/v1')->name('api.v1.')->group(function () {
                Route::post('toggle-tenant-company-status', [TenantCompanyAPIController::class, 'toggleTenantCompanyStatus'])->name('toggle-tenant-company-status');
            });
        }
    }
);


Route::middleware($middleware)->group(
    function () {
        Route::group(['prefix' => 'V11'], function () {
            Route::post('central-login', [AuthController::class, 'centralLogin']);
        });
    }
);