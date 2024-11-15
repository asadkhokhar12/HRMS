<?php

namespace App\Http\Controllers\Backend\Leave;

use App\Models\Role\Role;
use Illuminate\Http\Request;
use App\Models\Hrm\Leave\LeaveType;
use App\Models\Hrm\Leave\LeaveYear;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Department\Department;
use App\Repositories\Admin\RoleRepository;
use App\Http\Requests\Hrm\Leave\AssignLeaveRequest;
use App\Repositories\Hrm\Leave\LeaveTypeRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Leave\AssignLeaveRepository;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Department\DepartmentRepository;

class AssignLeaveController extends Controller
{
    use RelationshipTrait, ApiReturnFormatTrait;

    protected AssignLeaveRepository $assignLeave;
    protected RoleRepository $role;
    protected LeaveTypeRepository $leaveType;
    protected DepartmentRepository $departmentRepository;
    protected $model;
    protected $user_repository;

    public function __construct(AssignLeaveRepository $assignLeaveRepository, RoleRepository $role, LeaveTypeRepository $leaveType, AssignLeave $model, DepartmentRepository $departmentRepository, UserRepository $user_repository)
    {
        $this->assignLeave = $assignLeaveRepository;
        $this->role = $role;
        $this->leaveType = $leaveType;
        $this->model = $model;
        $this->departmentRepository = $departmentRepository;
        $this->user_repository = $user_repository;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->assignLeave->table($request);
            }
            $data['class']  = 'leave_assign_table';
            $data['fields'] = $this->assignLeave->fields();
            $data['checkbox'] = true;
            $data['title'] = _trans('leave.Assign leave');
            $data['departments'] = $this->departmentRepository->getAll();
            $data['users'] = $this->user_repository->getAll();

            return view('backend.leave.assign.index', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $data['title'] = _trans('leave.Create Assign Leave');
            $data['url'] = route('assignLeave.store');

            // Fetch all departments
            $departments = Department::all(); // 
            $data['departments'] = $departments;

            if (settings('leave_assign') == 1) { // employee
                $data['attributes'] = $this->assignLeave->createUserAttributes();
            } else {
                $data['attributes'] = $this->assignLeave->createAttributes();
            }

            @$data['button'] = _trans('common.Save');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function dataTable(Request $request)
    {
        try {
            return $this->assignLeave->dataTable($request, $id = null);
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(AssignLeaveRequest $request)
    {
        try {
            if (!$request->ajax()) {
                Toastr::error(_trans('response.Please click on button!'), 'Error');
                return redirect()->back();
            }

            return $this->assignLeave->store($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function show($id)
    {
        return $this->assignLeave->show($id);
    }

    // annual leave summary
    public function leaveSummery(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                return $this->assignLeave->leaveSummaryTable($request, $id);
            }
            $assign_leave = AssignLeave::where('id', $id)->first();
            $data['root_id'] = @$assign_leave->user_id;
            $data['leave_type'] = @$assign_leave->type_id;
            $data['class']  = 'leave_summary_table';
            $data['fields'] = $this->assignLeave->leaveSummaryFields();
            $data['checkbox'] = false;
            $data['title'] = _trans('leave.Annual Leave Summary');
            return view('backend.leave.assign.leave_summary', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function leaveTransferIndex(LeaveYear $leaveYear)
    {
        try {
            $data['title'] = _trans('common.Leave Carryover');
            $data['url']          = route('assignLeave.transfer', $leaveYear->id);
            $data['attributes'] = $this->assignLeave->editLeaveSummaryAttributes($leaveYear);
            @$data['button']   = _trans('common.Update');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function leaveTransfer(Request $request, $id)
    {
        try {
            return $this->assignLeave->updateLeaveSummary($request, $id);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    // annual leave summary end

    public function edit(AssignLeave $assignLeave)
    {
        try {
            $data['title'] = _trans('common.Edit Assign Leave');
            $data['url']          = route('assignLeave.update', $assignLeave->id);
            $data['attributes'] = $this->assignLeave->editAttributes($assignLeave);
            @$data['button']   = _trans('common.Update');
            return view('backend.modal.create', compact('data'));
        } catch (\Throwable $th) {
            return response()->json('fail');
        }
    }

    public function update(AssignLeaveRequest $request, $id)
    {
        try {
            if (!$request->ajax()) {
                Toastr::error(_trans('response.Please click on button!'), 'Error');
                return redirect()->back();
            }

            return $this->assignLeave->update($request, $id);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function isAlreadyAssigned($request)
    {
        $exists = AssignLeave::where([
            'type_id' => $request->type_id,
            'role_id' => $request->role_id,
        ])->first();
        if (!$exists) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(AssignLeave $assignLeave)
    {

        return $this->assignLeave->destroy($assignLeave->id);
    }

    // status change
    public function statusUpdate(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot do it for demo'), [], 400);
        }
        return $this->assignLeave->statusUpdate($request);
    }

    // destroy all selected data

    public function deleteData(Request $request)
    {
        if (demoCheck()) {
            return $this->responseWithError(_trans('message.You cannot delete for demo'), [], 400);
        }
        return $this->assignLeave->destroyAll($request);
    }
}
