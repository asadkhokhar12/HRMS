<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hrm\Leave\DailyLeave;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Http\Requests\Hrm\Leave\DailyLeaveRequest; 
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\DailyLeave\EloquentDailyLeaveRepository;

class DailyLeaveController extends Controller
{
    use RelationshipTrait, DateHandler, ApiReturnFormatTrait, FirebaseNotification;

    protected EloquentDailyLeaveRepository $dailyLeave;
    protected $model;

    public function __construct(EloquentDailyLeaveRepository $dailyLeaveRepository, DailyLeave $dailyLeave)
    {
        $this->dailyLeave = $dailyLeaveRepository;
        $this->model = $dailyLeave;
    }

    public function index(Request $request)
    {
        try {

            if ($request->ajax()) {
                return $this->dailyLeave->table($request);
            }
            $data['title']     =_trans('leave.Daily Leave');
            $data['class']     = 'daily_leave_table';
            $data['fields']    = $this->dailyLeave->fields();
            $data['checkbox']  = true;
            $data['table']     = route('daily_leave.index');
            $data['url_id']    = 'daily_leave_table_url';

            $data['departments'] = resolve(DepartmentRepository::class)->getAll();
            return view('backend.leave.daily-leave.index', compact('data'));
        } catch (\Exception $e) {
            dd($e);
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $data['title'] = _trans('common.Create Daily Leave');
            // $data['leaveTypes'] = $this->dailyLeave->getUserAssignLeave();
            $data['teamLeaders'] = User::where('status_id', 1)->select('id', 'name')->get();
            return view('backend.leave.daily-leave.create', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $date = explode('T', $request->datetime);
            $request['date'] = $this->databaseFormat($date[0]);
            $request['time'] = $date[1].":00";
            $data = $this->dailyLeave->store($request);
            if ($data->original['result']) {
                Toastr::success(_trans('response.Daily leave created successfully'), 'Success');
            } else {
                Toastr::error('Leave is not available for you', 'Error');
            }
            return redirect()->route('daily_leave.index');
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function requestApproveOrReject(DailyLeave $dailyLeave, $status): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->dailyLeave->approveOrRejectOrCancel($dailyLeave->id, $status);
            if ($data) {
                Toastr::success(_trans('response.Operation successful'), 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation is not successful', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function delete(DailyLeave $dailyLeave): \Illuminate\Http\RedirectResponse
    {
        return  $this->dailyLeave->destroy($dailyLeave->id);
    }

    // public function edit($id)
    // {
    //     try {
    //         // Find and show the daily leave data for editing
    //         $dailyLeave = $this->dailyLeave->find($id);
    //         $data['title'] = _trans('leave.Edit daily leave');
    //         return view('backend.leave.daily_leave.edit', compact('data', 'dailyLeave'));
    //     } catch (\Exception $e) {
    //         Toastr::error(_trans('response.Something went wrong!'), 'Error');
    //         return redirect()->back();
    //     }
    // }

    // public function update(DailyLeaveRequest $request, $id)
    // {
    //     try {
    //         // Validate, update, and redirect
    //         $this->dailyLeave->update($id, $request->validated());

    //         Toastr::success(_trans('response.Daily leave updated successfully'), 'Success');
    //         return redirect()->route('daily_leave.index');
    //     } catch (\Exception $e) {
    //         Toastr::error(_trans('response.Something went wrong!'), 'Error');
    //         return redirect()->back();
    //     }
    // }

    // public function show($id)
    // {
    //     try {
    //         // Find and show the daily leave data
    //         $dailyLeave = $this->dailyLeave->find($id);
    //         $data['title'] = _trans('leave.View daily leave');
    //         return view('backend.leave.daily_leave.show', compact('data', 'dailyLeave'));
    //     } catch (\Exception $e) {
    //         Toastr::error(_trans('response.Something went wrong!'), 'Error');
    //         return redirect()->back();
    //     }
    // }

    // public function delete($id)
    // {
    //     try {
    //         // Delete daily leave and redirect
    //         $this->dailyLeave->destroy($id);

    //         Toastr::success(_trans('response.Daily leave deleted successfully'), 'Success');
    //         return redirect()->route('daily_leave.index');
    //     } catch (\Exception $e) {
    //         Toastr::error(_trans('response.Something went wrong!'), 'Error');
    //         return redirect()->back();
    //     }
    // }

    // status change
    public function statusUpdate(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
        }
        return $this->dailyLeave->statusUpdate($request);
    }

    // destroy all selected data

    public function deleteData(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        }
        return $this->dailyLeave->destroyAll($request);
    }
}
