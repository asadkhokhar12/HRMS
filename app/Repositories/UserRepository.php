<?php

namespace App\Repositories;

use stdClass;
use App\Models\User;
use App\Models\Role\Role;
use Illuminate\Support\Str;
use App\Models\Company\Company;
use App\Models\Hrm\Shift\Shift;
use App\Models\UserShiftAssign;
use Illuminate\Validation\Rule;
use App\Services\Hrm\LeaveService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Hrm\Leave\AssignLeave;
use App\Services\Hrm\LeaveBalanceService;
use App\Helpers\CoreApp\Traits\SmsHandler;
use App\Mail\Hrm\AutoGeneratePasswordMail;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\MailHandler;
use Modules\Saas\Entities\UserTenantMapping;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Http\Resources\Location\LocationCollection;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class UserRepository
{

    use FileHandler, SmsHandler, AuthorInfoTrait, RelationshipTrait, ApiReturnFormatTrait, MailHandler;

    public $model;
    public $userShift;

    public function __construct(User $model, UserShiftAssign $userShift)
    {
        $this->model = $model;
        $this->userShift = $userShift;
    }

    public function getAll()
    {
        return $this->model->query()->where('company_id', $this->companyInformation()->id)->where('branch_id', userBranch())->get();
    }
    public function getActiveAll()
    {
        return $this->model->query()->where('status_id', 1)->where('company_id', $this->companyInformation()->id)->get();
    }

    public function getShift()
    {
        if (!isMainCompany())
        return Shift::query()->where('company_id', $this->companyInformation()->id)->get();
    }
    public function getActiveShift()
    {
        if (!isMainCompany())
        return Shift::query()->where('status_id', 1)->where('company_id', $this->companyInformation()->id)->get();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getUserByKeywords($request)
    {
        $where = [];
        if ($request->has('department_id')) {
            $where = array('department_id' => $request->get('department_id'));
        }
        if ($request->has('params')) {
            $where = array_merge($where, $request->get('params'));
        }
        return $this->model->query()->where('company_id', $this->companyInformation()->id)
            ->where($where)
            ->where('name', 'LIKE', "%$request->term%")
            ->select('id', 'name', 'phone', 'employee_id')
            ->where('branch_id', userBranch())
            ->take(10)
            ->get();
    }

    public function save($request)
    {
        
        DB::beginTransaction();
        try {
            if (empty($request->joining_date)) {
                $request['joining_date'] = date('Y-m-d');
            }
            if ($request->permissions) {
                $request['permissions'] = $request->permissions;
            } else {
                $request['permissions'] = [];
            }
            // $password = getCode(8);
            $request['company_id'] = $this->companyInformation()->id;
            if ($request->password_type == 'default') {
                $newPassword = 12345678;
                $request['password'] = $newPassword;
            } else {
                $newPassword = $request->password;
            }

            // if ($request->password == '') {
            //     $password = Str::random(8);
            // } else {
            //     $password = $request->password;
            // }
            $request['password'] = Hash::make($request->password);
            $request['country_id'] = $request->country;
            $request['employee_id'] = $request->employee_id;
            if ($request->avatar) {
                $this->deleteImage(asset_path($request->avatar_id));
                $avatar_id = $this->uploadImage($request->avatar, 'uploads/user')->id;
                $request['avatar_id'] = $avatar_id;
            }
            $request['branch_id'] = userBranch();
         

            // attendance method information
            $request['attendance_method'] = array_fill_keys($request->attendance_method ?? [], 1);

            $user = $this->model->query()->create($request->except('shift_id'));
          
            foreach($request->shift_id  as $shift){
                $new_shift = new $this->userShift;
                $new_shift->user_id = $user->id;
                $new_shift->shift_id = $shift;
                $new_shift->save();
            }
            $user->userRole()->create([
                'user_id' => $user->id,
                'role_id' => $request->role_id,
            ]);

            try {
            // Send the email with the plain password
             Mail::to($user->email)->send(new AutoGeneratePasswordMail('12345678'));
            } catch (\Throwable $th) {

                Log::info("central user error::" .$th);
            }
            
            // try {
            //     tenancy()->central(function ($tenant) use($user){
            //         $tenantSubdomain = Str::slug($tenant->id);
            //         $centralDomain = @base_settings('company_domain');
            //         $tenantDomain = $tenantSubdomain . '.' . $centralDomain;
            //         $company = Company::where('subdomain',$tenantDomain)->first();
            //             UserTenantMapping::updateOrCreate(
            //                 [
            //                 'company_id' => $company->id,
            //                     'tenant_id' => $tenant->id,
            //                     'tenant_user_id' => $user->id,
            //                     'domain' => $tenantDomain,
            //                 ],
            //                 [
            //                     'email' => $user->email,
            //                 ]
            //             );
            //     });

            // } catch (\Throwable $th) {
            //     Log::info("central user error::" .$th);
            // }
            
            DB::commit();
            return $this->responseWithSuccess(_trans('message.Employee successfully Created.'), $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    public function getByIdWithDetails($id)
    {
        return $this->model->with('department', 'designation', 'role', 'shift')->where('id', $id)->first();
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            
            $user = $this->model->query()->find($id);

          
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->joining_date = $request->joining_date;
            $user->department_id = $request->department_id;
            $user->designation_id = $request->designation_id;
            $user->address = $request->address;
            $user->religion = $request->religion;
            $user->country_id = $request->country;
            if($request->shift_id){
                $this->userShift->where('user_id',$user->id)->delete();
                foreach($request->shift_id as $shift){
                    $new_shift = new $this->userShift;
                    $new_shift->user_id = $user->id;
                    $new_shift->shift_id = $shift;
                    $new_shift->save();
                }
                

            }
          //  $user->shift_id = $request->shift_id;


            $user->marital_status = $request->marital_status;
            if($request->speak_language){
                $user->speak_language = $request->speak_language;
            }
            if($request->employee_id){
                $user->employee_id = $request->employee_id;
            }
            $user->basic_salary = $request->basic_salary;
            $user->role_id = $request->role_id;
            $user->birth_date = $request->birth_date;
            $user->manager_id = $request->manager_id;
            // $user->permissions = $request->permissions;
            $user->is_free_location = $request->is_free_location;
            $user->time_zone = $request->time_zone ?? 'Asia/Dhaka';
            if ($request->password_type == 'default') {
                $newPassword = 12345678;
                $user->password = Hash::make($newPassword);
            }else if ($request->password_type == 'custom') {
                $newPassword = $request->password;
                $user->password = Hash::make($newPassword);
            }
        

            if ($request->avatar) {
                $user->avatar_id = $this->uploadImage($request->avatar, 'uploads/user')->id;
            }

            // attendance method information
            //$defaultAttendanceMethods = [ 0 => 'normal_attendance'];
            //$attendanceMethods = array_merge($defaultAttendanceMethods, $request->attendance_method);
            $user->attendance_method = $request->attendance_method ? array_fill_keys($request->attendance_method, 1) : null;
            
            //author info update here
            $user->status_id = $request->status; 
            $user->save();
            // $role = RoleUser::where('user_id', $user->id)->first();
            // $role->role_id = $user->role_id;
            // $role->save();
            $this->updatedBy($user);

            DB::commit();

            try{
                tenancy()->central(function ($tenant) use($user){
                    $tenantSubdomain = Str::slug($tenant->id);
                    $centralDomain = @base_settings('company_domain');
                    $tenantDomain = $tenantSubdomain . '.' . $centralDomain;
                    $company = Company::where('subdomain',$tenantDomain)->first();
    
                    UserTenantMapping::updateOrCreate(
                        [
                            'company_id' => $company->id,
                            'tenant_id' => $tenant->id,
                            'tenant_user_id' => $user->id,
                            'domain' => $tenantDomain,
                        ],
                        [
                            'email' => $user->email,
                            
                        ]
                    );
                    
                });
            }
            catch (\Throwable $th) {
                Log::info('Central user updating error' .$th);
            }
            
            return $this->responseWithSuccess(_trans('response.User update successfully.'), $user);
            return $user;
        } catch (\Throwable $th) {
           
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function permission_update($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->query()->find($id);
            $user->permissions = $request->permissions;
            $user->save();
            $this->updatedBy($user);
            DB::commit();
            return $this->responseWithSuccess(_trans('response.User Permission update successfully.'), $user);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function updateProfile($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->query()->find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birth_date = $request->birth_date;

            if ($request->avatar) {
                $this->deleteImage(asset_path($user->avatar_id));
                $user->avatar_id = $this->uploadImage($request->avatar, 'uploads/user')->id;
            }
            DB::commit();
            $user->save();
            //author info update here
            $this->updatedBy($user);
            Toastr::success('Operation successful!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return back();
        }
    }

    public function delete($user)
    {
        $user->delete();
        return true;
    }

    public function changeStatus($user, $status)
    {
        $user->update([
            'status_id' => $status,
        ]);
        return true;
    }
    public function makeHR($user_id)
    {
        try {
            $user = $this->model->query()->find($user_id);
            if ($user->is_hr == 1) {
                $user->is_hr = 0;
                $user->update();
                $message = _trans('message.HR role removed successfully');
            } else {
                $user->is_hr = 1;
                $user->update();
                $message = _trans('message.HR role updated successfully');
            }
            return $this->responseWithSuccess($message, $user);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }

        return true;
    }

    public function data_table($request, $id = null)
    {

        $users = $this->model->query()->with('department', 'designation', 'role', 'shift', 'status')
            ->where('id', '!=', $this->companyInformation()->id)
            ->where('company_id', $this->companyInformation()->id)
            ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'email', 'phone', 'shift_id', 'status_id', 'is_hr');
        if (@$request->from && @$request->to) {
            $users = $users->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }

        if (@$request->userTypeId) {
            $users = $users->where('role_id', $request->userTypeId);
        }
        if (@$request->user_id) {
            $users = $users->where('id', $request->user_id);
        }
        $users = $users->latest()->get();

        return datatables()->of($users)
            ->addColumn('action', function ($data) {
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                $unBanned = _trans('common.Unbanned');
                $banned = _trans('common.Banned');
                $registerFace = _trans('common.Register Face');
                // $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');

                if (hasPermission('profile_view')) {
                    $action_button .= actionButton('Profile', route('user.profile', [$data->id, 'official']), 'profile');
                }
                if (hasPermission('user_edit')) {
                    $action_button .= actionButton($edit, route('user.edit', $data->id), 'profile');
                }

                if (isModuleActive('FaceAttendance') && hasPermission('registerFace')) {
                    $action_button .= actionButton($registerFace, route('user.RegisterFace', $data->id), 'registerFace');
                }
                if ($data->status_id == 3) {
                    if (hasPermission('user_banned')) {
                        $action_button .= actionButton($unBanned, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                } else {
                    if (hasPermission('user_unbanned')) {
                        $action_button .= actionButton($banned, 'ApproveOrReject(' . $data->id . ',' . "3" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                }
                if (hasPermission('user_delete')) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`dashboard/user/delete/`)', 'delete');
                }

                if (hasPermission('make_hr')) {

                    if ($data->is_hr == "1") {
                        $hr_btn = _trans('leave.Remove HR');
                    } else {
                        $hr_btn = _trans('leave.Make HR');
                    }
                    $action_button .= actionButton($hr_btn, 'MakeHrByAdmin(' . $data->id . ',`dashboard/user/make-hr/`,`HR`)', 'approve');
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('name', function ($data) {
                if ($data->is_hr == 1) {
                    $actAsHr = _trans('Acting as HR');
                    $hr_badge = @$data->name . ' </br><small class="text-success">[' . $actAsHr . ']</small>';
                } else {
                    $hr_badge = @$data->name . "";
                }
                return @$hr_badge;
            })
            ->addColumn('email', function ($data) {
                return @$data->email;
            })
            ->addColumn('phone', function ($data) {
                return @$data->phone;
            })
            ->addColumn('department', function ($data) {
                return @$data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return @$data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return @$data->role->name;
            })
            ->addColumn('shift', function ($data) {
                return @$data->shift->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'email', 'phone', 'department', 'designation', 'role', 'shift', 'status', 'action'))
            ->make(true);
    }

    function isWithinTimeLimit($givenDatetime) {
        $givenDatetime = strtotime($givenDatetime);
        $currentDatetime = time();

        $timeDifferenceInSeconds = abs($currentDatetime - $givenDatetime);

        return $timeDifferenceInSeconds <= 5;
    }

    public function liveTrackingEmployee($request, $id = null)
    {
        $location_list = [];
        try {
            $now = now()->subMinute(5)->toDateTimeString();

            $firebase_data = Firebase::firestore()
                ->database()
                ->collection('hrm_employee_track')
                ->where('datetime', '>=', $now)
                ->orderBy('datetime')
                ->documents();
         
            
            foreach ($firebase_data as $value) {
                $dataNeeded = [
                    'location_log', 'address', 'datetime'
                ];
                $data = $value->data();
                $data['location_log'] = ['latitude' => $data['latitude'], 'longitude' => $data['longitude']];
                $data = array_intersect_key($data, array_flip($dataNeeded));
                $data['name'] = User::find($value->id())?->name;
                $data['difference'] = $this->isWithinTimeLimit($data['datetime']);
                $location_list[] = $data;
            }

            return $location_list;
        } catch (\Throwable $th) {
            return $location_list;
        }
        
    }


    public function employeeLocationHistory($request, $id = null)
    {
        $logs = DB::table('location_logs')
            ->select('latitude', 'longitude', 'address as start_location', 'id', 'created_at')
            ->where('company_id', $this->companyInformation()->id)
            ->where('user_id', $request->user)
            ->where('date', 'LIKE', $request->date . '%')
            ->get();

        $data = [];
        $total = $logs->count();
        foreach ($logs as $key => $value) {
            if ($total > 25 ? ($key % ceil($total / 25)) == 0 || $key == 0 || $key == $total - 1 : true) {
                // Format the created_at timestamp
                $formattedCreatedAt = date('j F Y, h:i a', strtotime($value->created_at));
                $value->created_at = $formattedCreatedAt;
                
                array_push($data, $value);
            }
        }
        return $data;
    }
    

    public function departmentWiseUser($request)
    {
        $users = $this->model->query()->where('company_id', $this->companyInformation()->id);
        $users = $users->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'email', 'phone', 'status_id');

        return datatables()->of($users->latest()->get())
            ->addColumn('action', function ($data) {
                $action_button = '';
                $action_button .= actionButton('Profile', route('user.profile', [$data->id, 'official']), 'profile');

                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('name', function ($data) {
                return @$data->name;
            })
            ->addColumn('email', function ($data) {
                return @$data->email;
            })
            ->addColumn('phone', function ($data) {
                return @$data->phone;
            })
            ->addColumn('department', function ($data) {
                return $data->department->title;
            })
            ->addColumn('designation', function ($data) {
                return $data->designation->title;
            })
            ->addColumn('role', function ($data) {
                return $data->role->name;
            })
            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('name', 'email', 'phone', 'department', 'designation', 'role', 'status', 'action'))
            ->make(true);
    }

    // new function for user list

    public function leaveBalanceFields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Image'),
            _trans('common.Contact'),
            _trans('common.Employee Details'),
            _trans('common.Leave Summary'),
            _trans('common.Available Leave'),
            _trans('common.Action'),
        ];
    }

    public function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Image'),
            _trans('common.Registered Face'),
            _trans('common.Email'),
            _trans('common.Phone'),
            _trans('common.Designation'),
            _trans('common.Department'),
            _trans('common.Role'),
            _trans('common.Shift'),
            _trans('common.Status'),
            _trans('common.Action'),

        ];
    }

    public function leaveBalanceTable($request)
    {{
        $data = $this->model->query()->where('company_id', $this->companyInformation()->id)->where('branch_id', userBranch())
            ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'avatar_id', 'name', 'email', 'phone', 'status_id', 'shift_id', 'is_free_location', 'is_hr', 'is_admin')
            ->where('company_id', auth()->user()->company_id);
        $where = array();
        if ($request->search) {
            $where[] = ['name', 'like', '%' . $request->search . '%'];
        }
        if (@$request->designation) {
            $where[] = ['designation_id', $request->designation];
        }
        $data = $data
            ->where($where)
            ->paginate($request->limit ?? 2);

        return [
            'data' => $data->map(function ($data) {
                if (@$data->is_free_location == 1) {
                    $location = '<br>[<small class="text-info">' . _trans('common.Free Location') . '</small>]';
                }

                if (@$data->is_hr == 1) {
                    $hr = '<br>[<small class="text-success">' . _trans('common.Acting as HR') . '</small>]';
                }
                $user_image = '';
                $user_image .= '<img data-toggle="tooltip" data-placement="top" title="' . $data->name . '" src="' . uploaded_asset($data->avatar_id) . '" class="staff-profile-image-small" >';
                $contact = '<b>Email: </b>' . @$data->email . '<br><b>Phone: </b>' . @$data->phone;
                $details = '<b>Department: </b>' . @$data->department->title . '<br><b>Designation: </b>' . @$data->designation->title . '<br><b>Role: </b>' . @$data->role->name . '<br><b>Shift: </b>' . @$data->shift->name . '<br><small class="mt-3 badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>';
                $request = new stdClass();
                $request->user_id = $data->user_id;

                // $leave_details = @resolve(LeaveService::class)->leaveSummary($request)->original['data'] ?? '';
                $leave_details = @resolve(LeaveService::class)->leaveCountingSummary($data)->original['data'] ?? '';

                $leave_summary = '<b>Leave Allowed: </b>' . @$leave_details["total_leave"] . '<br><b>Leave Granted: </b>' . @$leave_details["total_used"]  . '<br><b>Leave Left: </b>' . @$leave_details["leave_balance"];
                $available_leave = '';
                foreach($leave_details['available_leave'] as $availables){
                    $htm = '<div class="d-flex justify-content-between text-center">
                            <span><b>' . $availables['type'] . ':</b></span>
                            <span>&emsp;</span>
                            <span><b>Total: </b>' . $availables['total_leave'] . '&ensp;|&ensp;<b>Left: </b>' . $availables['left_days'] . '</b></span>
                    </div>';
                    $available_leave .= $htm;
                }

                $action_button = '';
                $action_button .= actionButton(_trans('common.Edit'), 'mainModalOpen(`' . route('leaveRequest.balance.edit', $data->id) . '`)', 'modal');
                $button = ' <div class="dropdown dropdown-action">
                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    ' . $action_button . '
                                    </ul>
                                </div>';

                return [
                    'name' => $data->name . '' . @$location . '' . @$hr,
                    'avatar' => $user_image,
                    'contact' => $contact,
                    'details' => $details,
                    'leave_summary' => $leave_summary,
                    'available_leave' => $available_leave,
                    'id' => $data->id,
                    'action'     => $button,
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' => $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
    }


    function editLeaveBalanceAttributes($updateModel)
    {
        return $updateModel->map(function ($item) use ($updateModel) {
            return [
                'field' => 'input',
                'type' => 'number',
                'required' => true,
                'id'    => 'days',
                'class' => 'form-control ot-form-control ot-input',
                'col'   => 'col-md-6 form-group mb-3',
                'value' => $item->days,
                'label' => _trans('common.Days'),
                'title' => $item->type->name,
                'leave_type_id' => $item->id,
            ];
        } );
    }

    public function updateLeaveBalance($request){
        try {
            foreach ($request->leave as $key => $value){
                $assignLeaveModel = AssignLeave::where('id', $key)->first();
                if (!empty($assignLeaveModel)) {
                    $assign_leave = $assignLeaveModel;
                    $assign_leave->days = $value[0];
                    $assign_leave->save();
                }else{
                    return $this->responseWithError(_trans('message.Assign Leave not found'),[], 400);
                }
            }
            return $this->responseWithSuccess(_trans('message.Leave balance updated successfully.'), 200);
            
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }


    public function table($request)
    {{
        // Log::info($request->all());
        $data = $this->model->query()->where('company_id', $this->companyInformation()->id)->where('branch_id', userBranch())
            // ->where('status_id', 1)
            ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'avatar_id', 'face_data', 'face_image', 'name', 'email', 'phone', 'status_id', 'shift_id', 'is_free_location', 'is_hr', 'is_admin')
            ->where('company_id', auth()->user()->company_id);
        $where = array();
        if ($request->search) {
            $where[] = ['name', 'like', '%' . $request->search . '%'];


            // $attendance->where(function ($query) use ($request) {
            //     $query->whereHas('user', function ($query) use ($request) {
            //         $query->where('name', 'like', '%' .  request()->get('search') . '%');
            //     })
            //     ->orWhereHas('user.department', function ($query) use ($request) {
            //         $query->where('title', 'like', '%' . $request->search . '%');
            //     });
            // });
            
        }
        if (@$request->designation) {
            $where[] = ['designation_id', $request->designation];
        }
        if (@$request->userStatus) {      // active status filter
            $where[] = ['status_id', $request->userStatus];
        }
        if (!@$request->userStatus) {     // default active status loading
            $where[] = ['status_id', 1];  
        }
        $data = $data
            ->where($where)
            ->paginate($request->limit ?? 2);

        return [
            'data' => $data->map(function ($data) {
              
                $action_button = '';
                $edit = _trans('common.Edit');
                $delete = _trans('common.Delete');
                $unBanned = _trans('common.Unbanned');
                $banned = _trans('common.Banned');
                $registerFace = _trans('common.Register Face');
                // $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/department/delete/`)', 'delete');

                if (hasPermission('profile_view')) {
                    $action_button .= actionButton(_trans('common.Profile'), route('user.profile', [$data->id, 'personal']), 'profile');
                }
                if (hasPermission('user_edit')) {
                    $action_button .= actionButton($edit, route('user.edit', $data->id), 'profile');
                }
                if ( hasPermission('registerFace') &&  isModuleActive('FaceAttendance') ) {
                    $action_button .= actionButton($registerFace, route('user.registerFace', $data->id), 'new_page');
                }
                if (hasPermission('user_permission')) {
                    $action_button .= actionButton(_trans('common.Permission'), route('user.permission_edit.profile', $data->id), 'profile');
                }
                if ($data->status_id == 3) {
                    if (hasPermission('user_banned')) {
                        $action_button .= actionButton($unBanned, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                } else {
                    if (hasPermission('user_unbanned') && !$data->is_admin) {
                        $action_button .= actionButton($banned, 'ApproveOrReject(' . $data->id . ',' . "3" . ',`dashboard/user/change-status/`,`Approve`)', 'approve');
                    }
                }
                if (hasPermission('user_delete') && !$data->is_admin) {
                    $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`dashboard/user/delete/`)', 'delete');
                }
                if (hasPermission('user_edit')) {
                    $icon = 'success';
                    $action_button .= actionButton(_trans('common.Password Reset Mail'), 'GlobalSweetAlert(`' . _trans('common.Password Reset Mail') . '`,`' . _trans('alert.Are you sure?') . '`,`' . $icon . '`,`' . _trans('common.Yes') . '`,`' . route('user.sendResetMail', $data->id) . '`)', 'approve');
                }
                if (hasPermission('make_hr')) {

                    if ($data->is_hr == "1") {
                        $hr_btn = _trans('leave.Remove HR');
                        $icon = 'warning';
                    } else {
                        $hr_btn = _trans('leave.Make HR');
                        $icon = 'success';
                    }
                    $action_button .= actionButton($hr_btn, 'GlobalSweetAlert(`' . $hr_btn . '`,`' . _trans('alert.Are you sure?') . '`,`' . $icon . '`,`' . _trans('common.Yes') . '`,`' . route('user.make_hr', $data->id) . '`)', 'approve');
                    // $action_button .= actionButton($hr_btn, 'MakeHrByAdmin(' . $data->id . ',`dashboard/user/make-hr/`,`HR`)', 'approve');
                }
                $button = ' <div class="dropdown dropdown-action">
                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    ' . $action_button . '
                                    </ul>
                                </div>';
                if (@$data->is_free_location == 1) {
                    $location = '<br>[<small class="text-info">' . _trans('common.Free Location') . '</small>]';
                }

                if (@$data->is_hr == 1) {
                    $hr = '<br>[<small class="text-success">' . _trans('common.Acting as HR') . '</small>]';
                }
                $user_image = '';
                $user_image .= '<img data-toggle="tooltip" data-placement="top" title="' . $data->name . '" src="' . uploaded_asset($data->avatar_id) . '" class="staff-profile-image-small" >';
                $registered_face = '<img data-toggle="tooltip" data-placement="top" title="' . $data->name . '" src="' . uploaded_asset($data->face_image) . '" class="staff-profile-image-small" >';
                return [
                    'name' => $data->name . '' . @$location . '' . @$hr,
                    'avatar' => $user_image,
                    'registered_face' => $registered_face,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'department' => @$data->department->title,
                    'designation' => @$data->designation->title,
                    'role' => @$data->role->name,
                    'shift' => $data->shifts ? $data->all_shifts()->pluck('name')->implode(', ') : auth()->user()->shift->name,
                    'id' => $data->id,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'action' => $button,
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' => $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
    }
    public function phoneBookTable($request)
    {{
        // Log::info($request->all());
        $data = $this->model->query()->where('company_id', $this->companyInformation()->id)
            ->select('id', 'company_id', 'role_id', 'department_id', 'designation_id', 'name', 'email', 'phone', 'status_id', 'shift_id', 'created_at');
        if ($request->from && $request->to) {
            $data = $data->whereBetween('created_at', start_end_datetime($request->from, $request->to));
        }
        $data = $data->orderBy('name', 'asc')
            ->paginate($request->limit ?? 2);
        return [
            'data' => $data->map(function ($data) {

                return [
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'department' => $data->department->title,
                    'designation' => $data->designation->title,
                    'role' => $data->role->name,
                    'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' => $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
    }

    // statusUpdate
    public function statusUpdate($request)
    {
        try {
            // Log::info($request->all());
            if (@$request->action == 'active') {
                $userI = $this->model->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['status_id' => 1]);
                return $this->responseWithSuccess(_trans('message.User activate successfully.'), $userI);
            }
            if (@$request->action == 'inactive') {
                $userI = $this->model->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['status_id' => 4]);
                return $this->responseWithSuccess(_trans('message.User inactivate successfully.'), $userI);
            }
            return $this->responseWithError(_trans('message.User status change failed'), [], 400);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroyAll($request)
    {
        try {
            if (@$request->ids) {
                $user = $this->model->where('company_id', auth()->user()->company_id)->whereIn('id', $request->ids)->update(['deleted_at' => now()]);
                return $this->responseWithSuccess(_trans('message.User activate successfully.'), $user);
            } else {
                return $this->responseWithError(_trans('message.User not found'), [], 400);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function phonebookFields()
    {
        return [
            _trans('common.Name'),
            _trans('common.Email'),
            _trans('common.Phone'),
            _trans('common.Designation'),
            _trans('common.Department'),
            _trans('common.Role'),
            _trans('common.Status'),
        ];
    }

    public function sendResetMail($id)
    {
        try {
            $user = $this->model->query()->find($id);
            $password = getCode(8);
            $user->password = Hash::make($password);
            $user->update();
            if (!$this->sendEmail($user, $password)) {
                return $this->responseWithError(_trans('message.Mail not send.'), [], 400);
            } else {
                return $this->responseWithSuccess(_trans('message.Mail send successfully.'), [], 200);
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function resetDevice($user_id, $device)
    {
        try {
            $user = $this->model->query()->find($user_id);
            if ($device == 'mobile') {
                $user->app_token = null;
                $user->device_id = null;
                $user->device_info = null;
            } else {
                $user->device_uuid = null;
            }
            $user->last_login_device = null;

            $user->save();
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
            return false;
        }
    }
}
