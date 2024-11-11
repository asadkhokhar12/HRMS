<?php

namespace App\Http\Controllers\Backend\Report;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Admin\RoleRepository;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Track\LocationLog;
use App\Repositories\Report\AttendanceReportRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Repositories\Report\MachineAttendanceReportRepository;

class AttendanceReportController extends Controller
{
    use RelationshipTrait, DateHandler;

    protected $attendanceReport;
    protected $machineAttendanceReport;
    protected $department;
    protected $roleRepository;
    protected $attendance_repo;
    protected $userRepository;
    protected $users;

    public function __construct(
        AttendanceReportRepository $attendanceReportRepository,
        MachineAttendanceReportRepository $machineAttendanceReportRepository,
        DepartmentRepository $department,
        UserRepository $users,
        AttendanceRepository $attendance_repo,
        RoleRepository $roleRepository
    ) {
        $this->attendanceReport = $attendanceReportRepository;
        $this->machineAttendanceReport = $machineAttendanceReportRepository;
        $this->department = $department;
        $this->users = $users;
        $this->attendance_repo = $attendance_repo;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->attendanceReport->table($request);
            }
            $data['class']  = 'report_attendance_table';
            $data['fields'] = $this->attendance_repo->report_fields();
            $data['checkbox'] = true;
            $data['table']     = route('attendance.index');
            $data['url_id']    = 'report_attendance_table_url';
            $data['title'] = _trans('attendance.Attendance History');
            $data['departments'] = $this->department->getAll();
            $data['users'] = $this->users->getAll();
            return view('backend.report.attendance.index', compact('data'));
        } catch (\Throwable $th) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function liveTracking(Request $request)
    {
        $data['title'] = _trans('attendance.Live Tracking');
        $data['roles'] = $this->roleRepository->getAll();
        $data['date'] = $request->date ? $request->date : date('Y-m-d');
        return view('backend.report.live_tracking.index', compact('data'));
    }

    public function liveTrackingEmployee(Request $request)
    {
        return $this->users->liveTrackingEmployee($request);
    }

    public function locationHistory(Request $request)
    {
        $data['title'] = _trans('attendance.Location History');
        $data['users'] = $this->users->getAll();
        $data['date'] = $request->date ? $request->date : date('Y-m-d');
        $data['user'] = $request->user ? $request->user : null;
        return view('backend.report.live_tracking.location_history', compact('data'));
    }
    public function locationTimeline(Request $request)
    {
       
        $data['title'] = _trans('attendance.Location Timeline');
        $data['timeline'] = LocationLog::where('user_id', $request->user)->where('date', $request->date)->get();
        $data['users'] = $this->users->getAll();
        $data['date'] = $request->date ? $request->date : date('Y-m-d');
        $data['user'] = $request->user ? $request->user : null;
        $data['input'] = $request->all();
        return view('backend.report.live_tracking.location_timeline', compact('data'));
    }

    public function employeeLocationHistory(Request $request)
    {
        return $this->users->employeeLocationHistory($request);
    }

    public function employeeAttendanceHistory(User $user)
    {
        $data['title'] = _trans('attendance.Show attendance');
        $data['show'] = $user;
        $data['monthArray'] = $this->getCurrentMonthDays();
        return view('backend.attendance.attendance.show', compact('data'));
    }

    public function employeeMachineAttendanceHistory(User $user)
    {
        $data['title'] = _trans('attendance.Show Machine attendance');
        $data['show'] = $user;
        $data['monthArray'] = $this->getCurrentMonthDays();
        return view('backend.attendance.attendance.machine-show', compact('data'));
    }

    public function reportDataTable(Request $request)
    {
        return $this->attendanceReport->attendanceDatatable($request);
    }

    public function singleReportDataTable(Request $request, User $user)
    {
        if ($request->month) {
            $monthArray = $this->getSelectedMonthDays($request->month);
        } else {
            $monthArray = $this->getCurrentMonthDays();
        }
        return $this->attendanceReport->singleAttendanceDatatable($user, $request, $monthArray);
    }

    public function singleAttendanceSummaryReport(Request $request, User $user)
    {
        $monthlySummary = $this->attendanceReport->singleAttendanceSummary($user, $request);
        return view('backend.attendance.attendance.summary.summary', compact('monthlySummary'));
    }


    public function checkInDetails(Request $request)
    {
        $data['title'] = _trans('attendance.Attendance Details');
        $data['attendance'] = $this->attendanceReport->attendanceDetails($request);
        return view('backend.modal.attendance_details', compact('data'));
    }

    public function checkInOutApprovalOnTime($id, $type)
    {
        $this->attendanceReport->attendanceOnTimeApproval($id, $type);
        if($type === 'checkin'){
            Toastr::success(_trans('response.Check In Approved Successfully'), 'Success');
        } else{
            Toastr::success(_trans('response.Check Out Approved Successfully'), 'Success');
        }
        return redirect()->back();
    }


    public function reportMachineDataTable(Request $request)
    {
        return $this->machineAttendanceReport->attendanceDatatable($request);
    }

    public function singleMachineReportDataTable(Request $request, User $user)
    {
        if ($request->month) {
            $monthArray = $this->getSelectedMonthDays($request->month);
        } else {
            $monthArray = $this->getCurrentMonthDays();
        }
        return $this->machineAttendanceReport->singleAttendanceDatatable($user, $request, $monthArray);
    }

    public function singleMachineAttendanceSummaryReport(Request $request, User $user)
    {
        $monthlySummary = $this->machineAttendanceReport->singleAttendanceSummary($user, $request);
        return view('backend.attendance.attendance.summary.summary', compact('monthlySummary'));
    }
}
