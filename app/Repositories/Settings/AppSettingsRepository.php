<?php

namespace App\Repositories\Settings;

use App\Models\User;
use App\Enums\AttendanceMethod;
use App\Models\UserShiftAssign;
use Illuminate\Support\Facades\DB;
use App\Models\UserDocumentRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\coreApp\Setting\IpSetup;
use Illuminate\Support\Facades\Storage;
use App\Models\Hrm\AppSetting\AppScreen;
use App\Repositories\DashboardRepository;
use App\Services\Hrm\EmployeeBreakService;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Repositories\DutyScheduleRepository;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Http\Resources\Hrm\AppScreenCollection;
use App\Repositories\Hrm\Notice\NoticeRepository;
use App\Repositories\Settings\ApiSetupRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Content\AllContentRepository;
use App\Repositories\Settings\CompanyConfigRepository;
use Modules\MultiShift\Repositories\MultiShiftRepository;
use App\Repositories\Settings\ProfileUpdateSettingRepository;

class AppSettingsRepository
{
    use RelationshipTrait, ApiReturnFormatTrait, FileHandler;

    protected $companyConfig;
    protected $appScreen;
    protected $dashboardRepository;
    protected $dutyScheduleRepository;
    protected $allContents;
    protected $config_repo;
    protected $thirdPartyApiRepository;
    protected $notice_repository;
    protected $profileUpdateSettingRepository;
    protected $documentRequest;

    public function __construct(
        CompanyConfig           $companyConfig,
        AppScreen               $appScreen,
        DashboardRepository     $dashboardRepository,
        CompanyConfigRepository $companyConfigRepo,
        DutyScheduleRepository  $dutyScheduleRepository,
        AllContentRepository    $allContents,
        ApiSetupRepository      $thirdPartyApiRepository,
        NoticeRepository        $notice_repository,
        ProfileUpdateSettingRepository $profileUpdateSettingRepository,
        UserDocumentRequest     $documentRequest,
    )
    {
        $this->companyConfig = $companyConfig;
        $this->appScreen = $appScreen;
        $this->dashboardRepository = $dashboardRepository;
        $this->config_repo = $companyConfigRepo;
        $this->dutyScheduleRepository = $dutyScheduleRepository;
        $this->allContents = $allContents;
        $this->thirdPartyApiRepository = $thirdPartyApiRepository;
        $this->notice_repository = $notice_repository;
        $this->profileUpdateSettingRepository = $profileUpdateSettingRepository;
        $this->documentRequest = $documentRequest;
    }

    public function companyBaseSettings()
    {
        date_default_timezone_set(auth()->user()->country->time_zone??'Asia/Karachi');

        //get con=
        $data = [];

        $data['is_admin'] = auth()->user()->is_admin ? true : false;
        $data['is_hr'] = auth()->user()->is_hr ? true : false;
        $data['is_manager'] = auth()->user()->myTeam()->count() > 0 ? true : false;
        $data['is_face_registered'] = auth()->user()->face_data ? true : false;
        $data['multi_checkin'] = isset($this->companySetup()['multi_checkin']) ? $this->companySetup()['multi_checkin']== 1 ? true:false: false;
        $data['location_bind'] = isset($this->companySetup()['location_check']) ? $this->companySetup()['location_check']== 1 ? true:false: false;
        $data['is_ip_enabled'] = $this->isIpRestricted();
        $data['departments']=$this->profileUpdateSettingRepository->getAllDepartment()->getData()->data->departments;
        $data['designations']=$this->profileUpdateSettingRepository->getAllDesignation()->getData()->data->designations;
        $data['employee_types']=config('hrm.employee_type');
        $data['permissions'] = auth()->user()->permissions;
        
        $data['time_wish'] = $this->timeWish();
        $data['time_zone'] = auth()->user()->country->time_zone??'Asia/Karachi';
        $data['currency_symbol'] = $this->companySetup()['currency_symbol'] ?? '$';
        $data['currency_code'] = $this->companySetup()['currency_code'] ?? 'USD';
        $data['attendance_method'] = $this->companySetup()['attendance_method'] ?? AttendanceMethod::NORMAL;
        $data['duty_schedule'] = $this->dutyScheduleRepository->getUserToDaySchedule();
        $data['location_services'] = [
            'google'=> $this->thirdPartyApiRepository->getConfig('google') ? $this->thirdPartyApiRepository->getConfig('google')->status_id == 1 ? true : false:false,
            'barikoi'=> $this->thirdPartyApiRepository->getConfig('barikoi')?$this->thirdPartyApiRepository->getConfig('barikoi')->status_id == 1 ? true : false:false,
        ];
        $data['google_api_key'] = $this->thirdPartyApiRepository->getConfig('google')->key??null;
        $data['barikoi_api'] = $this->thirdPartyApiRepository->location_api();
        $data['break_status'] = resolve(EmployeeBreakService::class)->isBreakRunning();
        $data['live_tracking'] = ['app_sync_time' => $this->appSyncTime(), 'live_data_store_time' => $this->liveDataStoreTime()];
        $data['location_service'] = $this->locationService();

        //$data['app_theme'] = DB::table('settings')->where('name', 'default_theme')->value('value');
        $appTheme = DB::table('settings')->where('name', 'default_theme')->value('value');
        if($appTheme === 'app_theme_1'){
            $app_text = 'earth';
        } elseif($appTheme === 'app_theme_2'){
            $app_text = 'mars';
        } elseif($appTheme === 'app_theme_3'){
            $app_text = 'neptune';
        }
        $data['app_theme'] = $app_text;
        
        $data['is_team_lead']=auth()->user()->myTeam()->count() > 0 ? true : false;
        $data['notification_channels'] = auth()->user()->notification_channels();

        $data['multi_shift'] = $this->getMultipleShift() ?? [];

        $filePath = base_path('modules_statuses.json');

        if (file_exists($filePath)) {
            $json_content = file_get_contents($filePath);
            $modules = json_decode($json_content, true);
        } else {
            $modules = [];
        }

        $data['modules'] = $modules;

        $attendance_method_permission = auth()->user()->attendance_method;

        if (!$attendance_method_permission) {
            $data['attendance_methods'] = [];
        }
        if (isset($attendance_method_permission['normal_attendance']) && $attendance_method_permission['normal_attendance'] === 1) {
            $data['attendance_methods'] = [
                [
                    'title' => 'Normal Attendance', 
                    'short_description' => "“Normal attendance” simply means regular and expected presence.", 
                    'slug' => 'normal_attendance',
                    'image' => global_asset('images/attendance/normal-attendance.png')
                ]
            ];
        }
        if (isModuleActive('FaceAttendance') && isset($attendance_method_permission['face_attendance']) && $attendance_method_permission['face_attendance'] === 1) {
            $data['attendance_methods'][] = [
                'title' => 'Face Attendance', 
                'short_description' => "“Face attendance” tracked through facial recognition.", 
                'slug' => 'face_attendance',
                'image' => global_asset('images/attendance/face-attendance.png')
            ];
        }

        if (isModuleActive('QrBasedAttendance') && isset($attendance_method_permission['qr_based_attendance']) && $attendance_method_permission['qr_based_attendance'] === 1) {
            $data['attendance_methods'][] = [
                'title' => 'QR Attendance', 
                'short_description' => "“QR attendance” involves using QR codes for tracking presence.", 
                'slug' => 'qr_attendance',
                'image' => global_asset('images/attendance/qr-attendance.png')
            ];
        }

        if (isModuleActive('SelfieBasedAttendance') && isset($attendance_method_permission['selfie_based_attendance']) && $attendance_method_permission['selfie_based_attendance'] === 1) {
            $data['attendance_methods'][] = [
                'title' => 'Selfie Attendance', 
                'short_description' => "“Selfie attendance” individuals confirm their presence by taking a selfie.", 
                'slug' => 'selfie_attendance',
                'image' => global_asset('images/attendance/selfie-attendance.png')
            ];
        }

        // OfflineBasedAttendance
        if (isModuleActive('OfflineBasedAttendance') && isset($attendance_method_permission['offline_based_attendance']) && $attendance_method_permission['offline_based_attendance'] === 1) {
            $data['attendance_methods'][] = [
                'title' => 'Offline Attendance', 
                'short_description' => "Offline attendance individuals confirm their presence by giving attendance offline.", 
                'slug' => 'offline_attendance',
                'image' => global_asset('images/attendance/qr-attendance.png')
            ];
        }

        return $this->responseWithSuccess('Base settings information', $data, 200);
    }


    public function getMultipleShift()
    {
        $user_shift_list = [];
        
        foreach (auth()->user()->shifts as $key => $item) {
            $user_shift_list[] = [
                'shift_id' => $item->shift_id,
                'name' => $item->shift->name,
            ];
        }
        if(!@$user_shift_list){
            $user_shift_list[] = [
                'shift_id' => auth()->user()->shift_id,
                'name' => auth()->user()->shift->name,
            ];
        }
        return $user_shift_list;
    }

    public function isIpRestricted(): bool
    {
        $companyId = $this->companyInformation()->id;
        $isIpEnabled = CompanyConfig::where([
            'company_id' => $this->companyInformation()->id,
            'key' => 'ip_check',
            'value' => 1
        ])->first();
        if ($isIpEnabled) {
            return true;
        } else {
            return false;
        }
    }

    public function homeScreenData()
    {
        $report_permission="false";
        if (hasPermission('report') || hasPermission('report_menu')) {
            $report_permission="true";
        }
        $menus = $this->appScreen->query()->where('status_id', 1)->orderBy('position', 'ASC')
            ->select('name','slug','position','icon')
            ->when($report_permission=="false", function ($query) {
                return $query->where('slug', '!=', 'report');
            })
            ->get();
        foreach ($menus as $menu) {
            $image_type = pathinfo($menu->icon,PATHINFO_EXTENSION);
            $menu->image_type = $image_type;
            $menu->icon = my_asset($menu->icon);
        }
        $this_month_notice=$this->notice_repository->currentMonthNotice();

        $collection = [
            'data' => $menus,
            'total_notice' => $this_month_notice
        ];

        // $data = new AppScreenCollection($menus);
        return $this->responseWithSuccess('App home screen menus', $collection, 200);
    }

//    public function newTeamMate()
//    {
//        $menus = $this->appScreen->query()
//            ->where(['company_id' => $this->companyInformation()->id, 'department_id' => auth()->user()->department_id, 'status_id' => 1])
//            ->orderBy('position', 'ASC')
//            ->select('id', 'company_id', 'department_id', 'status_id')
//            ->get();
//
////        return $this->responseWithSuccess('App home screen menus', $data, 200);
//    }

    public function appScreenSetup()
    {
        $data = $this->appScreen->get();

        return $data;
    }

    public function appScreenSetupUpdate($request)
    {


        $data = \App\Models\Hrm\AppSetting\AppScreen::find($request->id);
        if ($request->status == 'true') {
            $data->status_id = 1;
        } else {
            $data->status_id = 4;
        }
        $data->save();

        return true;
    }

    public function timeWish()
    {
        // set default time zone
        date_default_timezone_set(auth()->user()->country->time_zone??'Asia/Karachi');

        $current_hour = date('H');
        $time_wish = [];

        if ($current_hour >= 6 && $current_hour < 12) {     // 6 - 11
            $time_wish['wish'] = _trans('response.Good Morning');
            $time_wish['sub_title'] = _trans('response.Have a good day with full of productivity and good vibes!');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-morning'));
        } elseif ($current_hour >= 12 && $current_hour < 14) {  //12-2 PM
            $time_wish['wish'] = _trans('response.Good Day');
            $time_wish['sub_title'] = _trans('response.Best wishes for your day!');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-day'));
        } elseif ($current_hour >= 12 && $current_hour < 16) {  //2-4 PM
            $time_wish['wish'] = _trans('response.Good Afternoon');
            $time_wish['sub_title'] = _trans('response.You almost done for today');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-evening'));
        } elseif ($current_hour >= 16 && $current_hour < 19) {  //4-6 PM
            $time_wish['wish'] = _trans('response.Good Evening');
            $time_wish['sub_title'] = _trans('response.Thank you for your hard work today');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-evening'));
        } elseif ($current_hour >= 19) {  //7 pm
            $time_wish['wish'] = _trans('response.Good Night');
            $time_wish['sub_title'] = _trans('response.Have a good night');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-night'));
        } elseif ($current_hour < 6) {  //6 AM
            $time_wish['wish'] = _trans('response.Good Night');
            $time_wish['sub_title'] = _trans('response.Have a good night');
            $time_wish['image'] = global_asset($this->dashboardRepository->getStatisticsImage('good-night'));
        }
        return $time_wish;

    }

    public function companySetup()
    {
        $configs = $this->config_repo->getConfigs();
        $config_array = [];
        foreach ($configs as $key => $config) {
            $config_array[$config->key] = $config->value;
        }
        $data = $config_array;
        return $data;
    }

    public function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }


    public function allContents($slug)
    {
        $data['contents'] = $this->allContents->getContent($slug);
        return $this->responseWithSuccess('All Contents', $data, 200);
    }


    public function appSyncTime()
    {
        $companyId = $this->companyInformation()->id;
        $data = CompanyConfig::where([
            'company_id' => $this->companyInformation()->id,
            'key' => 'app_sync_time',
        ])->first();

        if ($data) {
            return $data->value;
        } else {
            return '1';
        }
    }

    public function liveDataStoreTime()
    {
        $companyId = $this->companyInformation()->id;
        $data = CompanyConfig::where([
            'company_id' => $this->companyInformation()->id,
            'key' => 'live_data_store_time',
        ])->first();

        if ($data) {
            return $data->value;
        } else {
            return '2';
        }
    }


    public function locationService()
    {
        $companyId = $this->companyInformation()->id;
        $data = CompanyConfig::where([
            'company_id' => $this->companyInformation()->id,
            'key' => 'location_service',
            'value' => 1
        ])->first();

        if ($data) {
            return true;
        } else {
            return false;
        }
    }


    public function getScreenSetup()
    {
        try {
            $data = $this->appScreen->query()->where('status_id', 1)->pluck('slug');
            return $data;
        } catch (\Throwable $th) {
        }
    }

    public function updateTitle($data){
        try {
            $appSetting = $this->appScreen->findOrFail($data->id);
            $appSetting->name = $data->title;
            $appSetting->save();

            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function updateIcon($data){
        try {
            $appSetting = $this->appScreen->findOrFail($data->id);
            // Delete Old Icon
            if(Storage::exists($appSetting->icon)){
                Storage::delete($appSetting->icon);
            }

            // Upload New Icon
            $file = $data->file('icon');
            $final_path = $this->uploadImage($file, 'uploads/appSettings/icon')->img_path;

            // Set Icon
            $appSetting->icon = $final_path;

            $appSetting->save();

            Toastr::success(_trans('response.Operation successful'), 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function getDocumentRequest(){
        $query = $this->documentRequest->where(['company_id' => 1, 'user_id' => auth()->user()->id]);
        $query = $query->latest()->get();
        $data['lists'] = $query;
        return $this->responseWithSuccess('All Document Request', $data, 200);
    }

    public function submitDocumentRequest($request){
        try {
            $new = new $this->documentRequest;
            $new->user_id = auth()->user()->id;
            $new->branch_id = auth()->user()->branch_id;
            $new->company_id = 1;
            $new->request_type = $request->request_type;
            $new->request_description = $request->request_description;
            $new->approved = 0;
            $new->status_id = 2;
            $new->request_date = $request->request_date;
            $new->save();

            Toastr::success(_trans('response.New Document Request Created Successfully'), 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }
    
}
