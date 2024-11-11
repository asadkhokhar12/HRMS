<?php

namespace App\Http\Controllers\Api\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Leave\LeaveRequestRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;

class DailyLeaveController extends Controller
{
    use ApiReturnFormatTrait;
    protected $leaveRequest;
    public function __construct(LeaveRequestRepository $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function index(Request $request){
        try {
            if ($request->ajax()) {
                return $this->leaveRequest->dailyLeaveTable($request);
            }
            $data['title']=_trans('leave.Daily Leave');
            $data['class']  = 'daily_leave_table';
            $data['fields'] = $this->leaveRequest->daily_leave_fields();
            $data['checkbox'] = true;
            $data['table']     = route('dailyLeave.index');
            $data['url_id']        = 'daily_leave_table_url';

            $data['departments'] = resolve(DepartmentRepository::class)->getAll();
            return view('backend.leave.leaveRequest.daily_leave', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function report(Request $request){
        try {
            if ($request->ajax()) {
                return $this->leaveRequest->LeaveReportTable($request);
            }
            $data['title']=_trans('leave.Leave Report');
            $data['class']  = 'leave_report_table';
            $data['fields'] = $this->leaveRequest->leave_report_fields();
            $data['checkbox'] = true;
            $data['table']     = route('leaveReport.index');
            $data['url_id']        = 'leave_report_table_url';

            $data['departments'] = resolve(DepartmentRepository::class)->getAll();
            return view('backend.leave.leaveRequest.leave_report', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        try {
            return $this->leaveRequest->storeDailyLeave($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function listView(Request $request)
    {
        try {
            return $this->leaveRequest->dailyLeaveListView($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function staffListView(Request $request)
    {

        try {
            return $this->leaveRequest->staffListView($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function monthlySummeryView(Request $request)
    {

        try {
            return $this->leaveRequest->monthlySummeryView($request->all());
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }
    public function LeaveView(Request $request)
    {

        try {
            return $this->leaveRequest->LeaveView($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function approveRejectLeave(Request $request)
    {
        try {
            return $this->leaveRequest->approveRejectLeave($request);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }
}
