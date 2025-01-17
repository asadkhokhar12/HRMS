<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Validation\Rule;
use App\Services\Task\TaskService;
use App\Mail\Hrm\ResetPasswordMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\ActivityLogs\AuthorInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\SmsHandler;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Resources\Hrm\UserListCollection;
use App\Http\Resources\NotificationCollection;
use App\Repositories\Company\CompanyRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;

class ProfileRepository
{
    use FileHandler, SmsHandler, ApiReturnFormatTrait, DateHandler;

    protected User $user;
    protected $companyRepo;
    protected $userRepo;
    protected $department;
    protected $tasksService;

    public function __construct(
        User $user,
        CompanyRepository $companyRepo,
        UserRepository $userRepo,
        DepartmentRepository $department,
        TaskService $tasksService
    ) {
        $this->user = $user;
        $this->companyRepo = $companyRepo;
        $this->userRepo = $userRepo;
        $this->department = $department;
        $this->tasksService = $tasksService;
    }
    public function data_table($request)
    {
        $drivers = User::where('type', 'Driver')->latest()->get();
        return datatables()->of($drivers)
            ->addColumn('action', function ($data) {
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top" data-boundary="viewport" data-toggle="dropdown"> ' . __translate('common.Action', false) . '</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        ' . actionButton('Driver View', route('driver.dashboard', encrypt($data->id))) . '
                         ' . actionButton('Driver Delete', '__globalDelete(' . $data->id . ',`dashboard/drivers/delete/`)', 'delete') . '
                        </div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('role', function ($data) {
                return $data->type;
            })
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->driver->status->class . '">' . @$data->driver->status->name . '</span>';
            })
            ->addColumn('drivers', function ($data) {
                $getChildDrivers = AuthorInfo::where('authorable_type', 'App\Models\User')->where('created_by', $data->id)->get();
                $html = '';
                if ($getChildDrivers->count() > 0) {
                    foreach ($getChildDrivers as $key => $value) {
                        $user = User::where('id', $value->authorable_id)->first();
                        if ($user) {
                            if ($user->id != $value->created_by) {
                                $html .= '
                         <tr class="driver-table-data">
                            <td class="driver-table-new-data">' . $user->name . '</td>
                             <td class="driver-table-new-data">
                             <div class="bg-light-green">
                            <a href="' . route('driver.dashboard', encrypt($user->id)) . '" class="dropdown-item text-black">
                                <i class="bi bi-eye edit-icon-cus"></i>
                                </a>
                                </div>
                            </td>
                         </tr>
                        ';
                            }

                        }
                    }
                }

                if ($getChildDrivers->count() > 1) {
                    return $table = '<table class="table-checkable order-column sticker-cus-table" id = "example4">
                                <thead>
                                    <tr>
                                        <th class="sticker-table-head">Name </th>
                                        <th class="sticker-table-head">View </th
                                    </tr >
                                </thead >
                                <tbody >
                        ' . $html . '
                                </tbody >
                            </table > ';
                } else {
                    return '<span class="badge badge-danger" > ' . __translate('profile.No Driver Assign', false) . ' </span > ';
                }
            })
            ->rawColumns(array('action', 'role', 'status', 'drivers', 'name'))
            ->make(true);
    }

    public function UserProfileUpdate($request)
    {
        $user = User::find(Auth::user()->id);
        $request = $request->except('company_id', 'department_id', 'designation_id', 'role_id', 'password', 'face_data', 'is_admin', 'is_hr', 'shift_id', 'permissions', 'employee_id', 'employee_type', 'branch_id');
        $cloumns = Schema::getColumnListing('users');
        foreach ($request as $key => $value) {
            if (!in_array($key, $cloumns)) {
                continue;
            }
            $user->$key = $value;
        }
        $user->save();
        return $user;
    }

    public function getProfileDetails($request, $id): \Illuminate\Http\JsonResponse
    {
        $request['user_id'] = $id;
        // $user = $this->checkUser($request);
        //$user = Auth::user();
        $user = User::where('id', $id)->first();
        if ($user) {
            $data = [];
            $data['id'] = $user->id;
            $data['avatar'] = uploaded_asset($user->avatar_id);
            $data['name'] = $user->name;
            $data['designation'] = @$user->designation->title;
            $data['email'] = $user->email ?? null;
            $data['phone'] = $user->phone ?? null;
            $data['department'] = $user->department->title ?? null;
            $data['birth_date'] = $user->birth_date ?? null;
            $data['blood_group'] = $user->blood_group ?? null;
            $data['facebook_link'] = $user->facebook_link ?? null;
            $data['linkedin_link'] = $user->linkedin_link ?? null;
            $data['instagram_link'] = $user->instagram_link ?? null;
            $data['appreciates'] = [];

            $data['speak_language'] = $user->speak_language;
            $data['employee_id'] = $user->employee_id;

            // 1
            $data['passport_expire_date'] = date("m/d/Y", strtotime($user->passport_expire_date));
            $data['eid_expire_date'] = date("m/d/Y", strtotime($user->eid_expire_date));
            $data['visa_expire_date'] = date("m/d/Y", strtotime($user->visa_expire_date));
            $data['insurance_expire_date'] = date("m/d/Y", strtotime($user->insurance_expire_date));
            $data['labour_card_expire_date'] = date("m/d/Y", strtotime($user->labour_card_expire_date));

            // 2
            $data['passport_number'] = $user->passport_number ?? null;
            $data['eid_number'] = $user->eid_number ?? null;
            $data['visa_number'] = $user->visa_number ?? null;
            $data['insurance_number'] = $user->insurance_number ?? null;
            $data['labour_card_number'] = $user->labour_card_number ?? null;

            //3
            $data['passport_file'] = uploaded_asset($user->passport_file_id);
            $data['eid_file'] = uploaded_asset($user->eid_file_id);
            $data['visa_file'] = uploaded_asset($user->visa_file_id);
            $data['insurance_file'] = uploaded_asset($user->insurance_file_id);
            $data['labour_card_file'] = uploaded_asset($user->labour_card_file_id);

            // 4
            $data['eid_file_id'] = $user->eid_file_id;
            $data['visa_file_id'] = $user->visa_file_id;
            $data['insurance_file_id'] = $user->insurance_file_id;
            $data['labour_card_file_id'] = $user->labour_card_file_id;
            $data['passport_file_id'] = $user->passport_file_id;

            foreach ($user->appreciates as $key => $appreciate) {
                $data['appreciates'][] = [
                    'appreciate_by' => $appreciate->appreciateFrom->name,
                    'message' => $appreciate->message,
                    'date' => Carbon::parse($appreciate->date)->format('F j'),
                    'day' => Carbon::parse($appreciate->date)->format('l'),
                ];
            }
            return $this->responseWithSuccess('User information', $data, 200);
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }

    //get user particular information start
    public function checkUser($request)
    {
        return $this->user->with(['department:id,title', 'designation:id,title'])
            ->where('id', Auth::id())
            ->first();
    }

    public function getOfficialInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['name'] = $user->name ?? null;
        $data['email'] = $user->email ?? null;
        $data['phone'] = $user->phone ?? null;
        $data['address'] = $user->address ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        $data['department_id'] = @$user->department_id ?? null;
        $data['department'] = @$user->department->title ?? null;
        $data['designation_id'] = @$user->designation_id ?? null;
        $data['designation'] = @$user->designation->title ?? null;
        $data['joining_date'] = showDate($user->joining_date) ?? null;
        $data['joining_date_db'] = $user->joining_date ?? null;
        $data['employee_type'] = $user->employee_type ?? null;
        $data['employee_id'] = $user->employee_id ?? null;
        $data['manager_id'] = $user->manager_id ?? null;
        $data['manager'] = $user->manager->name ?? null;
        $data['grade'] = $user->grade ?? null;
        $data['is_free_location'] = $user->is_free_location ?? null;

        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getPersonalInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['department'] = @$user->department->title ?? null;
        $data['name'] = $user->name ?? null;
        $data['gender'] = $user->gender ?? null;
        $data['tin'] = $user->tin ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        $data['phone'] = $user->phone ?? null;
        $data['birth_date'] = showDate($user->birth_date) ?? null;
        $data['birth_date_db'] = $user->birth_date ?? null;
        $data['address'] = $user->address ?? null;
        $data['nationality'] = $user->nationality ?? null;
        $data['nid_card_number'] = $user->nid_card_number ?? null;
        $data['nid_card_id'] = uploaded_asset($user->nid_card_id);
        $data['nid_file'] = $user->nid_card_id;
        $data['tax'] = $user->tax;

        $data['speak_language'] = $user->speak_language;
        $data['employee_id'] = $user->employee_id;
        // 1
        $data['passport_expire_date'] = date("m/d/Y", strtotime($user->passport_expire_date));
        $data['eid_expire_date'] = date("m/d/Y", strtotime($user->eid_expire_date));
        $data['visa_expire_date'] = date("m/d/Y", strtotime($user->visa_expire_date));
        $data['insurance_expire_date'] = date("m/d/Y", strtotime($user->insurance_expire_date));
        $data['labour_card_expire_date'] = date("m/d/Y", strtotime($user->labour_card_expire_date));

        // 2
        $data['passport_number'] = $user->passport_number ?? null;
        $data['eid_number'] = $user->eid_number ?? null;
        $data['visa_number'] = $user->visa_number ?? null;
        $data['insurance_number'] = $user->insurance_number ?? null;
        $data['labour_card_number'] = $user->labour_card_number ?? null;

        //3
        $data['passport_file'] = uploaded_asset($user->passport_file_id);
        $data['eid_file'] = uploaded_asset($user->eid_file_id);
        $data['visa_file'] = uploaded_asset($user->visa_file_id);
        $data['insurance_file'] = uploaded_asset($user->insurance_file_id);
        $data['labour_card_file'] = uploaded_asset($user->labour_card_file_id);

        // 4
        $data['eid_file_id'] = $user->eid_file_id;
        $data['visa_file_id'] = $user->visa_file_id;
        $data['insurance_file_id'] = $user->insurance_file_id;
        $data['labour_card_file_id'] = $user->labour_card_file_id;
        $data['passport_file_id'] = $user->passport_file_id;

        $data['marital_status'] = $user->marital_status ?? null;
        $data['blood_group'] = $user->blood_group ?? null;
        $data['facebook_link'] = $user->facebook_link ?? null;
        $data['linkedin_link'] = $user->linkedin_link ?? null;
        $data['instagram_link'] = $user->instagram_link ?? null;
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getFinancialInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['tin'] = $user->tin ?? null;
        $data['bank_name'] = $user->bank_name ?? null;
        $data['bank_account'] = $user->bank_account ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getEmergencyInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['emergency_name'] = $user->emergency_name ?? null;
        $data['emergency_mobile_number'] = $user->emergency_mobile_number ?? null;
        $data['emergency_mobile_relationship'] = $user->emergency_mobile_relationship ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getSalaryInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['basic_salary'] = $user->basic_salary ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getContractInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['basic_salary'] = $user->basic_salary ?? 0;
        $data['contract_start_date'] = $user->contract_start_date ?? date('Y-m-d');
        $data['contract_end_date'] = $user->contract_end_date ?? date('Y-m-d');
        $data['payslip_type'] = $user->payslip_type ?? null;
        $data['late_check_in'] = $user->late_check_in ?? null;
        $data['early_check_out'] = $user->early_check_out ?? null;
        $data['extra_leave'] = $user->extra_leave ?? null;
        $data['monthly_leave'] = $user->monthly_leave ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }
    public function getCommissionsInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['salary_commission'] = $user->salary_setup ?? null;
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }
    public function getAttendanceInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['id'] = auth()->user()->id;
        $data['title'] = _trans('common.Attendance List');
        $data['users'] = $this->userRepo->getAll();
        $data['departments'] = $this->department->getAll();
        $data['permissions'] = \App\Models\Permission\Permission::get();
        $data['url'] = route('user.attendanceTable', $data['id']);
        $data['avatar'] = uploaded_asset(auth()->user()->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getTasksList($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['id'] = auth()->user()->id;
        $data['table'] = route('task.table');
        $data['url_id'] = 'task_table_url';
        $data['fields'] = $this->tasksService->fields();
        $data['class'] = 'task_table_class';
        $data['title'] = _trans('task.Tasks List');
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    public function getComplementInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['appreciates'] = [];
        foreach ($user->appreciates as $key => $appreciate) {
            $data['appreciates'][] = [
                'appreciate_by' => $appreciate->appreciateFrom->name,
                'message' => $appreciate->message,
                'date' => Carbon::parse($appreciate->date)->format('F j'),
                'day' => Carbon::parse($appreciate->date)->format('l'),
            ];
        }
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }
    public function getCompanyInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data = [];
        $data['company_info'] = $this->companyRepo->show($user->company_id);
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    // functions for
    public function newGetAttendanceInfo($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['title'] = _trans('common.Attendance List');
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }
    // notice
    public function getNoticeList($user, $slug): \Illuminate\Http\JsonResponse
    {
        $data['avatar'] = uploaded_asset($user->avatar_id);
        return $this->responseWithSuccess("User {$slug} information", $data, 200);
    }

    // update::ayman 06
    public function getProfile($request, $slug = 'official'): \Illuminate\Http\JsonResponse
    {
        // $user = $this->checkUser($request);
        $user = User::find($request->user_id) ?? Auth::user();
        if ($user) {
            if ($slug === 'official') {
                return $this->getOfficialInfo($user, $slug);
            } elseif ($slug === 'personal') {
                return $this->getPersonalInfo($user, $slug);
            } elseif ($slug === 'financial') {
                return $this->getFinancialInfo($user, $slug);
            } elseif ($slug === 'emergency') {
                return $this->getEmergencyInfo($user, $slug);
            } elseif ($slug === 'salary') {
                return $this->getSalaryInfo($user, $slug);
            } elseif ($slug === 'security') {
                return $this->getEmergencyInfo($user, $slug);
            } elseif ($slug === 'appreciates') {
                return $this->getComplementInfo($user, $slug);
            } elseif ($slug === 'company' && auth()->user()->is_admin == 1) {
                return $this->getCompanyInfo($user, $slug);
            } elseif ($slug === 'contract') {
                return $this->getContractInfo($user, $slug);
            } elseif ($slug === 'commissions') {
                return $this->getCommissionsInfo($user, $slug);
            } elseif ($slug === 'attendance') {
                return $this->newGetAttendanceInfo($user, $slug);
            } elseif ($slug === 'tasks') {
                return $this->getTasksList($user, $slug);
            } elseif ($slug === 'notice' || $slug === 'phonebook' || $slug === 'leave_request' || $slug == 'visit'
                || $slug == 'appointment' || $slug == 'ticket' || $slug == 'advance' || $slug == 'commission' || $slug == 'project'
                || $slug == 'task' || $slug == 'award' || $slug == 'travel' || $slug == 'settings') {
                return $this->getNoticeList($user, $slug);
            } else {
                return $this->responseWithError('No data found', [], 400);
            }
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }

    public function getProfileInfo($request): \Illuminate\Http\JsonResponse
    {
        // $user = $this->checkUser($request);
        $user = Auth::user();
        if ($user) {
            $data['official'] = $this->getOfficialInfo($user, 'official')->getData()->data;
            $data['personal'] = $this->getPersonalInfo($user, 'personal')->getData()->data;
            $data['financial'] = $this->getFinancialInfo($user, 'financial')->getData()->data;
            $data['emergency'] = $this->getEmergencyInfo($user, 'emergency')->getData()->data;

            return $this->responseWithSuccess('User profile information', $data, 200);
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }
    //get user particular information end

    public function updateFromApi($request)
    {
        $user = $this->user->query()->find(Auth::id());
        if ($user) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'sometimes|max:30',
                    'department_id' => 'sometimes',
                    'designation_id' => 'sometimes',
                    'manager_id' => 'sometimes',
                    'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
                    'phone' => 'sometimes|max:50|unique:users,phone,' . Auth::id(),
                    'birth_date' => 'sometimes|date',
                    'nationality' => 'sometimes|max:30',
                    'tin' => 'sometimes|max:50',
                    'bank_name' => 'sometimes|max:30',
                    'bank_account' => 'sometimes|max:50',
                ]
            );

            if ($validator->fails()) {
                return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
            }

            try {
                //update official information
                $user->name = $request->name;
                $user->email = $request->email;
                $user->joining_date = $request->joining_date;
                $user->department_id = intval($request->department_id);
                $user->designation_id = intval($request->designation_id);
                $user->employee_type = $request->employee_type;
                $user->manager_id = intval($request->manager_id);
                $user->grade = $request->grade;
                $user->employee_id = $request->employee_id;

                //update personal information
                $user->gender = $request->gender;
                $user->phone = $request->phone;
                $user->birth_date = $request->birth_date;
                $user->blood_group = $request->blood_group;
                $user->address = $request->address;
                $user->nationality = $request->nationality;
                $user->marital_status = $request->marital_status;

                if (@$request->speak_language) {
                    $user->speak_language = $request->speak_language;
                }
                if (@$request->employee_id) {
                    $user->employee_id = $request->employee_id; 
                }
                

                $user->facebook_link = $request->facebook_link;
                $user->linkedin_link = $request->linkedin_link;
                $user->instagram_link = $request->instagram_link;

                //update financial information
                $user->tin = $request->tin;
                $user->bank_name = $request->bank_name;
                $user->bank_account = $request->bank_account;
                //update financial information
                $user->emergency_name = $request->emergency_name;
                $user->emergency_mobile_number = $request->emergency_mobile_number;
                $user->emergency_mobile_relationship = $request->emergency_mobile_relationship;
                $user->save();

                $this->updateAttachedFiles($request, $user);
                return true;
            } catch (\Throwable $th) {

                Log::error($th);

                return false;
            }
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }
    public function update($request, $slug)
    {
        $user = $this->user->query()->find(Auth::id());
        if ($user) {
            if ($slug === 'official') {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:30',
                        'department_id' => 'required',
                        'designation_id' => 'required',
                        'manager_id' => 'required',
                        'email' => 'email|unique:users,email,' . Auth::id(),
                    ]
                );

                if ($validator->fails()) {
                    return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
                }

                //update official information
                $user->name = $request->name;
                $user->email = $request->email;
                $user->joining_date = $request->joining_date;
                $user->department_id = intval($request->department_id);
                $user->designation_id = intval($request->designation_id);
                $user->employee_type = $request->employee_type;
                $user->manager_id = intval($request->manager_id);
                $user->grade = $request->grade;
                $user->employee_id = $request->employee_id;
                $user->save();

                return $this->getOfficialInfo($user, $slug);
            } elseif ($slug === 'personal') {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'phone' => 'required|max:50|unique:users,phone,' . Auth::id(),
                        'birth_date' => 'sometimes|date',
                        'nationality' => 'sometimes|max:30',
                    ]
                );

                if ($validator->fails()) {
                    return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
                }

                try {
                    //update personal information
                    $user->gender = $request->gender;
                    $user->phone = $request->phone;
                    $user->birth_date = $request->birth_date;
                    $user->blood_group = $request->blood_group;
                    $user->address = $request->address;
                    $user->nationality = $request->nationality;
                    $user->marital_status = $request->marital_status;

                    if ($request->speak_language) {
                        $user->speak_language = $request->speak_language;
                    }

                    if ($request->employee_id) {
                        $user->employee_id = $request->employee_id;
                    }
                    $user->facebook_link = $request->facebook_link;
                    $user->linkedin_link = $request->linkedin_link;
                    $user->instagram_link = $request->instagram_link;

                    $user->save();
                    $this->updateAttachedFiles($request, $user);
                    return $this->getPersonalInfo($user, $slug);
                } catch (\Throwable $th) {
                    Log::error($th);

                    return false;
                }
            } elseif ($slug === 'financial') {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'tin' => 'sometimes|max:50',
                        'bank_name' => 'sometimes|max:30',
                        'bank_account' => 'sometimes|max:50',
                    ]
                );

                if ($validator->fails()) {
                    return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
                }

                //update financial information
                $user->tin = $request->tin;
                $user->bank_name = $request->bank_name;
                $user->bank_account = $request->bank_account;
                $user->save();

                return $this->getFinancialInfo($user, $slug);
            } elseif ($slug === 'salary') {
                //update basic salary information here need to add super admin permission for update basic salary
                $user->basic_salary = $request->basic_salary;
                $user->save();

                return $this->getFinancialInfo($user, $slug);
            } elseif ($slug === 'emergency') {

                //update financial information
                $user->emergency_name = $request->emergency_name;
                $user->emergency_mobile_number = $request->emergency_mobile_number;
                $user->emergency_mobile_relationship = $request->emergency_mobile_relationship;
                $user->save();

                return $this->getEmergencyInfo($user, $slug);
            } elseif ($slug === 'security') {
                //update security information
                if (Hash::check($request->password, $user->password)) {
                    $user->password = Hash::make($request->password_confirmation);
                    $user->save();
                } else {
                    return $this->responseWithError(__('Old password is incorrect'), [], 422);
                }

                return $this->getEmergencyInfo($user, $slug);
            } else {
                return $this->responseWithError('No data found', [], 400);
            }
        } else {
            return $this->responseWithError('No data found', [], 400);
        }
    }

    //forgot password start
    public function sendEmail($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 6);
            $user->verification_code = $rand;
            $user->save();
            Session::put('email', $user->email);
            Mail::to($user->email)->send(new ResetPasswordMail($user));
            return $this->responseWithSuccess('Mail sent successfully', [], 200);
        } else {
            return $this->responseWithError('No user found', [], 400);
        }
    }

    public function updatePassword($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'code' => 'required',
                'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:6',
                'password_confirmation' => 'required|min:6',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->where('verification_code', $request->code)->first();
        if ($user) {
            $user->verification_code = null;
            $user->password = Hash::make($request->password);
            $user->save();
            Session::forget('email');
            return $this->responseWithSuccess('Password updated successfully', [], 200);
        } else {
            return $this->responseWithError('Verification code is invalid', [], 400);
        }
    }

    //forgot password end

    public function adminPasswordUpdate($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:6',
                'password_confirmation' => 'required|min:6',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        $user = User::where('email', auth()->user()->email)->first();
        if ($user) {
            $checkPassword = Hash::check($request->old_password, $user->password);
            if ($checkPassword) {
                $user->password = Hash::make($request->password);
                $user->save();
                return $this->responseWithSuccess('Password updated successfully', [], 200);
            } else {
                return $this->responseWithError('Password did not matched', [], 422);
            }
        } else {
            return $this->responseWithError('No user found', [], 400);
        }
    }
    //forgot password end

    //password  update start
    public function changepassword($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:6',
                'password_confirmation' => 'required|min:6',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        $user = $this->user->find(Auth::user()->id);
        if (!$user) {
            return $this->responseWithError('No user found', [], 400);
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->responseWithError(__('Current password does not match'), [], 403);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return $this->responseWithSuccess('Password updated successfully', [], 200);
    }
    //password  update end

    //avatar update start

    public function avatarUpdate($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }

        $user = $this->user->find(Auth::id());
        if (!$user) {
            return $this->responseWithError(__('No data found'), $validator->errors(), 400);
        }
        if ($request->hasFile('avatar')) {
            $filePath = $this->uploadImage($request->avatar, 'uploads/avatar');
            $user->avatar_id = $filePath ? $filePath->id : null;
            $user->save();
        } else {
            $user->avatar_id = $request->avatar;
            $user->save();
        }

        $data['avatar'] = uploaded_asset($user->avatar_id);

        return $this->responseWithSuccess('Avatar updated successfully', $data, 200);
    }

    //avatar update end

    // passport::call - 3
    public function updateProfile($request, $slug)
    {
        $user = $this->user->query()->find($request->user_id);
        if ($user) {
            if ($slug === 'official') {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|max:30',
                        'email' => 'required|email|unique:users,email,' . $request->user_id,
                    ]
                );

                try {
                    //update official information
                    $user->name = $request->name;
                    $user->email = $request->email;
                    if (appSuperUser()) {
                        $user->joining_date = $request->joining_date;
                        $user->department_id = $request->department_id;
                        $user->designation_id = $request->designation_id;
                        $user->employee_type = $request->employee_type;
                    }

                    $user->manager_id = $request->manager_id;
                    $user->grade = $request->grade;
                    $user->employee_id = $request->employee_id;
                    $user->is_free_location = $request->is_free_location;
                    $user->save();
                    return true;
                } catch (\Exception $exception) {
                }
            } elseif ($slug === 'personal') {

                try {
                    //update personal information
                    $user->gender = $request->gender;
                    $user->phone = $request->phone;
                    $user->birth_date = date('Y-m-d', strtotime($request->birth_date));
                    $user->address = $request->address;
                    $user->nationality = $request->nationality;
                    $user->marital_status = $request->marital_status;
                    $user->nid_card_number = $request->nid_card_number;
                    $user->blood_group = $request->blood_group;

                    $user->facebook_link = $request->facebook_link;
                    $user->linkedin_link = $request->linkedin_link;
                    $user->instagram_link = $request->instagram_link;
                    $user->tin = $request->tin;

                    $user->speak_language = $request->speak_language;
                    $user->employee_id = $request->employee_id;
                    $user->tax = $request->tax;


                    //upload avatar start
                    if ($request->hasFile('avatar')) {
                        $filePath = $this->uploadImage($request->avatar, 'uploads/user');
                        $user->avatar_id = $filePath ? $filePath->id : null;
                    }
                    $user->save();
                    $this->updateAttachedFiles($request, $user);
                    return true;
                } catch (\Throwable $th) {
                    Log::error($th);
                    return false;
                }
            } elseif ($slug === 'financial') {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'tin' => 'sometimes|max:50',
                        'bank_name' => 'sometimes|max:30',
                        'bank_account' => 'sometimes|max:50',
                    ]
                );

                //update financial information
                $user->tin = $request->tin;
                $user->bank_name = $request->bank_name;
                $user->bank_account = $request->bank_account;
                $user->save();

                return true;
            } elseif ($slug === 'salary') {
                //update basic salary information here need to add super admin permission for update basic salary
                if (appSuperUser()) {
                    $user->basic_salary = $request->basic_salary;
                    $user->save();
                }

                return $this->getFinancialInfo($user, $slug);
            } elseif ($slug === 'contract') {
                //update basic salary information here need to add super admin permission for update basic salary
                if (appSuperUser()) {
                    $user->basic_salary = $request->basic_salary;
                    $user->contract_start_date = date('Y-m-d', strtotime($request->contract_start_date));
                    $user->contract_end_date = date('Y-m-d', strtotime($request->contract_end_date));
                    $user->payslip_type = $request->payslip_type;
                    $user->late_check_in = intval($request->late_check_in);
                    $user->early_check_out = $request->early_check_out;
                    $user->extra_leave = $request->extra_leave;
                    $user->monthly_leave = $request->monthly_leave;
                    $user->save();
                }
                return $this->getContractInfo($user, $slug);
            } elseif ($slug === 'emergency') {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'emergency_name' => 'sometimes|max:30',
                        'emergency_mobile_number' => 'sometimes|numeric|digits:11|regex:/(01)[0-9]{9}/',
                        'emergency_mobile_relationship' => 'sometimes|max:50',
                    ]
                );

                //update financial information
                $user->emergency_name = $request->emergency_name;
                $user->emergency_mobile_number = $request->emergency_mobile_number;
                $user->emergency_mobile_relationship = $request->emergency_mobile_relationship;
                $user->save();

                return true;
            } elseif ($slug === 'security') {
                //update security information
                $user->password = Hash::make($request->password_confirmation);
                $user->save();

                return true;
            } elseif ($slug === 'company') {

                //update company information
                $company = $this->companyRepo->updateCompanyData($request, auth()->user()->company->id);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getNotification($request)
    {
        $data = auth()->user()->notifications;
        $data = new NotificationCollection($data);
        return $this->responseWithSuccess('Get notifications', $data, 200);
    }
    public function readNotification($request)
    {
        auth()->user()->notifications->where('id', $request->notification_id)->first()->markAsRead();
        return $this->responseWithSuccess('Notification Read', [], 200);
    }

    public function clearNotification()
    {
        $data = auth()->user()->notifications->pluck('id');
        Notification::whereIn('id', $data)->delete();
        return $this->responseWithSuccess('Notification cleared', [], 200);
    }

    public function getUserList($request)
    {
        if ($request->keywords == "") {
            $array = [];
        } else {
            $keywords = \request('keywords');
            $users = $this->user->query()
                ->select('id', 'name', 'phone', 'designation_id', 'avatar_id')
                ->where('name', 'LIKE', "%$keywords%");
            $array = $users->take(20)->get();
        }
        $data = new UserListCollection($array);

        return $this->responseWithSuccess("Users Search Result", $data, 200);
    }

    //faceRecognition
    public function faceRecognition($request)
    {
        $validator = Validator::make($request->all(), [
            'face_data' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);
        }
        $user = auth()->user();
        $user->face_data = $request->face_data;

        if ($request->hasFile('face_image')) {
            $filePath = $this->uploadImage($request->face_image, 'uploads/face-register/');
            $user->face_image = $filePath ? $filePath->id : null;
        }

        $user->save();
        return $this->responseWithSuccess('Face Recognition Saved', [], 200);
    }

    //get face data
    public function getFaceData($request)
    {
        $user = auth()->user();
        return $this->responseWithSuccess('Face Recognition Data', $user->face_data, 200);
    }

    public function updateAttachedFiles($request, $user)
    {
        try {
            $fields = [
                'passport' => [
                    'number' => 'passport_number',
                    'file_id' => 'passport_file_id',
                    'expire_date' => 'passport_expire_date',
                ],
                'eid' => [
                    'number' => 'eid_number',
                    'file_id' => 'eid_file_id',
                    'expire_date' => 'eid_expire_date',
                ],
                'visa' => [
                    'number' => 'visa_number',
                    'file_id' => 'visa_file_id',
                    'expire_date' => 'visa_expire_date',
                ],
                'insurance' => [
                    'number' => 'insurance_number',
                    'file_id' => 'insurance_file_id',
                    'expire_date' => 'insurance_expire_date',
                ],
                'labour_card' => [
                    'number' => 'labour_card_number',
                    'file_id' => 'labour_card_file_id',
                    'expire_date' => 'labour_card_expire_date',
                ],
            ];
            foreach ($fields as $type => $field) {
                if ($request->has($field['number'])) {
                    $user->{$field['number']} = $request->{$field['number']};
                }
                if ($request->has($field['expire_date'])) {
                    $user->{$field['expire_date']} = date("Y-m-d", strtotime($request->{$field['expire_date']}));
                }
                if ($request->hasFile($field['file_id'])) {
                    $filePath = $this->uploadImage($request->{$field['file_id']}, 'uploads/users/' . $user->id ?? time() . $type);
                    $user->{$field['file_id']} = $filePath ? $filePath->id : null;
                }
            }
            $user->save();
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
