<?php

namespace App\Repositories\DailyLeave;

use App\Models\User;
use App\Mail\LeaveRequestMail;
use Illuminate\Support\Facades\Log;
use App\Models\Hrm\Leave\DailyLeave;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\ActivityLogs\AuthorInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Helpers\CoreApp\Traits\AuthorInfoTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\coreApp\Relationship\RelationshipTrait;

class EloquentDailyLeaveRepository implements DailyLeaveRepositoryInterface
{
    use FileHandler, DateHandler, ApiReturnFormatTrait, AuthorInfoTrait, RelationshipTrait, FirebaseNotification;

    protected DailyLeave $dailyLeave;
    protected UserRepository $userRepository;

    public function __construct(DailyLeave $dailyLeave, UserRepository $userRepository)
    {
        $this->dailyLeave = $dailyLeave;
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return DailyLeave::all();
    }

    public function find($id)
    {
        return DailyLeave::findOrFail($id);
    }

    public function create(array $data)
    {
        return DailyLeave::create($data);
    }

    public function getUserById($id)
    {
        return User::with('userRole')->find($id);
    }

    function fields()
    {
        return [
            _trans('common.ID'),
            _trans('common.Name'),
            _trans('common.Leave Type'),
            _trans('common.DateTime'),
            _trans('common.Reason'),
            _trans('common.Admin/HR Approved'),
           // _trans('common.TL Approved'),
            _trans('common.Status'),
            _trans('common.Action'),

        ];
    }

    function table($request)
    {
        try {
            // Log::info($request);
            $dailyLeave = $this->dailyLeave->query()->where('company_id', 1);
            // if (auth()->user()->role->slug == 'staff') {
            //     $dailyLeave = $dailyLeave->where('user_id', auth()->id());
            // } else {
            //     $dailyLeave->when(\request()->get('user_id'), function (Builder $builder) {
            //         return $builder->where('user_id', \request()->get('user_id'));
            //     });
            // }
            if ($request->from && $request->to) {
                $dailyLeave = $dailyLeave->whereBetween('date', start_end_datetime($request->from, $request->to));
            } else {
                $today = date('Y-m-d');
                $dailyLeave = $dailyLeave->where('date', '<=', $today);
            }
            if ($request->search) {
                $dailyLeave = $dailyLeave->whereHas('user', function ($builder) use ($request) {
                    return $builder->where('name', 'like', '%' . $request->search . '%');
                });
            }
            // $dailyLeave->when(\request()->get('type'), function (Builder $builder) {
            //     return $builder->where('status_id', \request()->get('type'));
            // });

            
            $data = $dailyLeave->orderBy('id', 'desc')->paginate($request->limit ?? 2);
            return [
                'data' => $data->map(function ($data) {
                    
                    $action_button = '';
                    $approve = _trans('common.Approve');
                    $reject = _trans('common.Reject');
                    $refer = _trans('common.Refer');
                    $delete = _trans('common.Delete');
        
                    if (hasPermission('leave_request_approve')) {
                        if ($data->status_id == 6 || $data->status_id == 17) {
                            $action_button .= actionButton($approve, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`hrm/daily-leave/approved-or-reject/`,`Approve`)', 'approve');
                        }
                        if ($data->status_id == 2) {
                            $action_button .= actionButton($approve, 'ApproveOrReject(' . $data->id . ',' . "1" . ',`hrm/daily-leave/approved-or-reject/`,`Approve`)', 'approve');
                            $action_button .= actionButton($reject, 'ApproveOrReject(' . $data->id . ',' . "6" . ',`hrm/daily-leave/approved-or-reject/`,`Reject`)', 'reject');
                        }
                    }

                    if (hasPermission('leave_request_approve')) {
                        if ($data->status_id == 1) {
                            $action_button .= actionButton($reject, 'ApproveOrReject(' . $data->id . ',' . "6" . ',`hrm/daily-leave/approved-or-reject/`,`Reject`)', 'reject');
                        }
                    }
                    if (hasPermission('leave_request_delete')) {
                        $action_button .= actionButton($delete, '__globalDelete(' . $data->id . ',`hrm/daily-leave/delete/`)', 'delete');
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

                    return [

                        'id' => $data->id,
                        'name' => $data->user->name,
                        'type' => str_replace('_', ' ', ucwords(str_replace(' ', '_', $data->leave_type))),
                        'datetime' => $data->date." ".$data->time,
                        'reason' => $data->reason,
                        //'hr_approved' => @AuthorInfo::where(['authorable_type' => get_class($this->dailyLeave), 'authorable_id' => $data->id])->first()->approveUser->name ? _trans('common.Yes') : _trans('attendance.Pending'),
                        'hr_approved' => @$data->hrApprovedBy->name ? _trans('common.Yes') : _trans('attendance.No'),
                        //'tl_approved' => @$data->tlApprovedBy->name ? _trans('common.Yes') : _trans('attendance.Pending'),
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
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    public function getUserAssignLeave()
    {
        if (settings('leave_assign') == 1) {
            return AssignLeave::with('type')->where([
                'company_id' => $this->companyInformation()->id,
                'user_id' => auth()->user()->id,
            ])->get();
        } else {
            return AssignLeave::with('type')->where([
                'company_id' => $this->companyInformation()->id,
                'department_id' => auth()->user()->department_id,
            ])->get();
        }
    }

    public function store($request)
    {
        $validator = Validator::make($request->all(), [
            'datetime' => 'required',
            'reason' => 'required',
            'leave_type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(__('Something Wrong'), $validator->errors(), 422);
        }
        try {
            $userDepartment = $this->getUserById($request->user_id);
            //check this user has appropriate role
            if ($userDepartment) {
                $user = $this->userRepository->getById($request->user_id);
                if ($user) {
                    $dailyLeave = new $this->dailyLeave();
                    $dailyLeave->user_id = $user->id;
                    $dailyLeave->company_id = $user->company->id;
                    $dailyLeave->leave_type = $request->leave_type;
                    $dailyLeave->date = $request->date;
                    $dailyLeave->time = $request->time;
                    $dailyLeave->reason = $request->reason;
                    $dailyLeave->status_id = 2;
                    $dailyLeave->save();

                    //created by instance here
                    $author = $this->createdBy($dailyLeave);
                    $dailyLeave->author_info_id = $author->id;
                    $dailyLeave->save();


                    $LeaveTypeString = str_replace('_', ' ', ucwords(str_replace(' ', '_', $request->leave_type)));
                    $notify_body = $LeaveTypeString . " Requested by " . auth()->user()->name;
                    $details = [
                        'title' => 'New Leave Request',
                        'body' => $notify_body,
                        'actionText' => 'View',
                        'actionURL' => [
                            'app' => 'leave_request',
                            'web' => route('leaveRequest.index'),
                            'target' => '_blank',
                        ],
                        'sender_id' => $user->id,
                    ];
                    $notification_for = [
                        'notification_for' => 'leave_request',
                        'notification_id' => null,
                    ];
                    //send notification to manager
                    if ($dailyLeave->user->manager_id != null) {
                        $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->manager_id, 'leave_requested', null, route('leaveRequest.index'), $details['title'], $details['body'], null);
                        sendDatabaseNotification($dailyLeave->user->manager, $details);
                        try {
                            Mail::to($dailyLeave->user->manager->email)->send(new LeaveRequestMail($dailyLeave->user, $details));
                        } catch (\Throwable $th) {
                            Log::error($th);
                        }
                    } elseif ($dailyLeave->user->myHr() != null) {
                        $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->myHr()->id, 'leave_requested', null, route('leaveRequest.index'), $details['title'], $details['body'], null);
                        sendDatabaseNotification($dailyLeave->user->myHr(), $details);
                        try {
                            Mail::to($dailyLeave->user->myHr()->email)->send(new LeaveRequestMail($dailyLeave->user, $details));
                        } catch (\Throwable $th) {
                            Log::error($th);
                        }
                    }

                    return $this->responseWithSuccess('Daily leave request has been created', [], 200);
                } else {
                    return $this->responseWithError('No user found', [], 400);
                }
            } else {
                return $this->responseWithError('This user has no role', [], 400);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function approveOrRejectOrCancel($id, $status): bool
    {
        $dailyLeave = $this->dailyLeave->query()->find($id);
        if ($dailyLeave) {
            $dailyLeave->status_id = $status;
            $dailyLeave->save();
            $msg_body = 'Your ' . $dailyLeave->leave_from . ' To ' . $dailyLeave->leave_to . ' leave request has been reviewed';

            if ($status == 1) {
                //send notification to staff
                $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->id, 'leave_approved', '', 'leave_approved', _trans('response.Leave Request Approved'), $msg_body, null);
                $this->approvedBy($dailyLeave);

                $dailyLeave->approved_by_hr = Auth::user()->id;
                $dailyLeave->approved_at_hr = now();
                $dailyLeave->rejected_by_hr = null;
                $dailyLeave->rejected_at_hr = null;
                $dailyLeave->save();

            } elseif ($status == 6) {
                //send notification to staff
                $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->id, 'leave_rejected', '', 'leave_rejected', _trans('response.Leave Request Rejected'), $msg_body, null);
                $this->rejectedBy($dailyLeave);

               
                $dailyLeave->rejected_by_hr = Auth::user()->id;
                $dailyLeave->rejected_at_hr = now();
                $dailyLeave->approved_by_hr = null;
                $dailyLeave->approved_at_hr = null;
                $dailyLeave->save();

            } elseif ($status == 7) {
                //send notification to staff
                $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->id, 'leave_cancelled', '', 'leave_cancelled', _trans('response.Leave Request Cancelled'), $msg_body, null);
                $this->cancelledBy($dailyLeave);
            } elseif ($status == 17) {
                //send notification to HR
                $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->myHr->id, 'leave_referred', '', 'leave_referred', _trans('response.Leave Request Referred'), 'Leave Request Referred', null);
                $this->referredBy($dailyLeave);
            } else {
                //send notification to staff
                $this->sendChannelFirebaseNotification('user' . $dailyLeave->user->id, 'leave_rejected', '', 'leave_rejected', _trans('response.Leave Request Rejected'), 'Leave Request Rejected', null);
                $this->rejectedBy($dailyLeave);
            }
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id)
    {
        $table_name = $this->dailyLeave->getTable();
        $foreign_id = \Illuminate\Support\Str::singular($table_name) . '_id';
        return \App\Services\Hrm\DeleteService::deleteData($table_name, $foreign_id, $id);
    }

    public function update($id, array $data)
    {
        $dailyLeave = $this->find($id);
        $dailyLeave->update($data);

        return $dailyLeave;
    }

    public function delete($id)
    {
        $dailyLeave = $this->find($id);
        $dailyLeave->delete();
    }

    public function updateStatus($id, $status)
    {
        $dailyLeave = $this->find($id);
        $dailyLeave->update(['status' => $status]);
    }

        // statusUpdate
        public function statusUpdate($request)
        {
            try {
                if (@$request->action == 'active') {
                    $leave_request = $this->dailyLeave->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 1]);
                    return $this->responseWithSuccess(_trans('message.Daily leave request activate successfully.'), $leave_request);
                }
                if (@$request->action == 'inactive') {
                    $leave_request = $this->dailyLeave->where('company_id', 1)->whereIn('id', $request->ids)->update(['status_id' => 4]);
                    return $this->responseWithSuccess(_trans('message.Daily leave request inactivate successfully.'), $leave_request);
                }
                return $this->responseWithError(_trans('message.Daily leave request inactivate failed'), [], 400);
            } catch (\Throwable $th) {
                return $this->responseWithError($th->getMessage(), [], 400);
            }
        }
    
        public function destroyAll($request)
        {
            try {
                if (@$request->ids) {
                    $leave_request = $this->dailyLeave->where('company_id', 1)->whereIn('id', $request->ids)->delete();
                    return $this->responseWithSuccess(_trans('message.Daily leave request delete successfully.'), $leave_request);
                } else {
                    return $this->responseWithError(_trans('message.Daily leave request inactivate failed'), [], 400);
                }
            } catch (\Throwable $th) {
                return $this->responseWithError($th->getMessage(), [], 400);
            }
        }
}
