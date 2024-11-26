<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Award\Award;
use App\Models\Visit\Visit;
use App\Enums\AttendanceStatus;
use App\Models\Company\Company;
use App\Models\Finance\Deposit;
use App\Models\Finance\Expense;
use App\Models\Management\Client;
use App\Models\Management\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Hrm\Meeting\Meeting;
use App\Models\TaskManagement\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Hrm\Task\EmployeeTask;
use App\Models\Accounts\IncomeExpense;
use App\Models\Hrm\Attendance\Holiday;
use App\Models\Hrm\Attendance\Weekend;
use App\Models\Hrm\Leave\LeaveRequest;
use App\Models\Expenses\PaymentHistory;
use App\Models\Hrm\AppSetting\AppScreen;
use App\Models\Hrm\Appoinment\Appoinment;
use App\Models\Hrm\Attendance\Attendance;
use App\Models\Hrm\Support\SupportTicket;
use App\Services\Hrm\EmployeeBreakService;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Repositories\Hrm\Notice\NoticeRepository;
use App\Repositories\Hrm\Meeting\MeetingRepository;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Settings\AppSettingsRepository;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Employee\AppoinmentRepository;
use App\Repositories\Report\AttendanceReportRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;

class DashboardRepository
{

    use ApiReturnFormatTrait, DateHandler, RelationshipTrait, TimeDurationTrait;

    protected $attendanceReportRepository;
    protected $attendance;
    protected $attendanceRepository;
    protected $appointment;
    protected $meeting;
    protected $appointRepo;

    public function __construct(AttendanceReportRepository $attendanceReportRepository, Attendance $attendance, AttendanceRepository $attendanceRepository, Appoinment $appointment, Meeting $meeting, AppoinmentRepository $appointRepo)
    {
        $this->attendanceReportRepository = $attendanceReportRepository;
        $this->attendance = $attendance;
        $this->attendanceRepository = $attendanceRepository;
        $this->appointment = $appointment;
        $this->meeting = $meeting;
        $this->appointRepo = $appointRepo;
    }

    public function getIncomeExpenseGraph($request)
    {
        if (!empty($request->time)) {
            $year = $request->time;
        } else {
            $year = date("Y");
        }
        $months = [];
        $income = [];
        $expense = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = date("m", mktime(0, 0, 0, $i, 1, $year));
            $total_income = IncomeExpense::where('type', 1)->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount');
            $total_expense = IncomeExpense::where('type', 2)->whereYear('created_at', $year)->whereMonth('created_at', $month)->sum('amount');
            if (empty($total_income)) {
                $total_income = 0;
            }
            $months[] = date('M', strtotime($i . '-' . $month . '-' . $year));
            $income[] = $total_income;
            $expense[] = $total_expense;
        }
        $data['label'] = $months;
        $data['income'] = $income;
        $data['expense'] = $expense;

        return $data;
    }

    public function getStatisticsImage($level)
    {
        $app_dashboard = config()->get('hrm.dashboard_images');
        return $app_dashboard[$level]['path'];
    }

    public function getNewStatisticsImage($level)
    {
        $app_dashboard = config()->get('hrm.company_dashboard_images');
        return @$app_dashboard[$level]['path'];
    }
    public function getApiDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];

            $screen_data =  AppScreen::where('status_id', 1)->pluck('slug')->toArray();
            if (in_array('appointments', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('appoinment')),
                    'title' => 'Appointments',
                    'slug' => 'appointment',
                    'number' => Appoinment::where('date', $date)
                        ->where(function ($query) {
                            $query->where('created_by', auth()->user()->id)
                                ->orWhere('appoinment_with', auth()->user()->id);
                        })
                        ->count(),
                ];
            }

            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('meeting')),
                'title' => 'Meetings',
                'slug' => 'meeting',
                'number' => Meeting::where('date', $date)->where('user_id', auth()->user()->id)->count(),
            ];
            if (in_array('visit', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('visit')),
                    'title' => 'Visit',
                    'slug' => 'visit',
                    'number' => Visit::where('date', $date)->where('user_id', auth()->user()->id)->count(),
                ];
            }

            if (in_array('support', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('support')),
                    'title' => 'Support Tickets',
                    'slug' => 'support_ticket',
                    'number' => SupportTicket::where('date', $date)
                        ->where('user_id', auth()->user()->id)
                        ->orWhere('assigned_id', auth()->user()->id)
                        ->where('status_id', 1)
                        ->where('type_id', 12)
                        ->count(),
                ];
            }
            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->singleAttendanceSummary(auth()->user(), $request);

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('late')),
                'title' => 'Late In',
                'slug' => 'late_in',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            if (in_array('leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('leave')),
                    'title' => 'Leave',
                    'slug' => 'leave',
                    'number' => str_replace(' days', '', $attendance_data['total_leave']),
                ];
            }
            if (in_array('daily-leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('early-leave')),
                    'title' => 'Early Leave',
                    'slug' => 'early_leave',
                    'number' => str_replace(' days', '', $attendance_data['total_left_early']),
                ];
            }
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('absent')),
                'title' => 'Absent',
                'slug' => 'absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            if (in_array('visit', $screen_data)) {

                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('visit')),
                    'title' => 'Visits',
                    'slug' => 'visits',
                    'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                        ->where('user_id', auth()->user()->id)
                        ->count(),
                ];
            }

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('rewards')),
                'title' => 'Rewards',
                'slug' => 'rewards',
                'number' => \App\Models\Award\Award::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                    ->where('user_id', auth()->user()->id)
                    ->count(),
            ];
            $appoinments = Appoinment::query();
            $appoinments = $appoinments->with('participants')
                ->where(function ($query) {
                    $query->where('created_by', auth()->user()->id)
                        ->orWhere('appoinment_with', auth()->user()->id);
                })
                ->when(request()->has('month'), function ($query) {
                    $query->where('date', 'LIKE', '%' . request('month') . '%');
                })
                ->when(!request()->has('month'), function ($query) {
                    $query->limit(5);
                })

                ->orderBy('id', 'desc')->get();
            $data['appoinment_list'] = $appoinments->map(function ($appoinment) {
                return [
                    'id' => $appoinment->id,
                    'title' => $appoinment->title,
                    'date' => Carbon::parse($appoinment->date)->format('F j'),
                    'day' => Carbon::parse($appoinment->date)->format('l'),
                    'time' => $this->dateTimeInAmPm($appoinment->appoinment_start_at),
                    'start_at' => $this->timeFormatInPlainText($appoinment->appoinment_start_at),
                    'end_at' => $this->timeFormatInPlainText($appoinment->appoinment_end_at),
                    'location' => $appoinment->location,
                    'appoinmentWith' => @$appoinment->appoinmentWith->name,
                    'participants' => $appoinment->participants->map(function ($participant) {
                        return [
                            'name' => $participant->participantInfo->name,
                            'is_agree' => $participant->is_agree == 1 ? 'Agree' : 'Disagree',
                            'is_present' => $participant->is_present == 1 ? 'Present' : 'Absent',
                            'present_at' => $participant->present_at,
                            'appoinment_started_at' => $participant->appoinment_started_at,
                            'appoinment_ended_at' => $participant->appoinment_ended_at,
                            'appoinment_duration' => $participant->appoinment_duration,
                        ];
                    }),
                ];
            });
            $holidays = Holiday::query()
                ->when(request()->has('month'), function ($query) {
                    $query->where('start_date', 'LIKE', '%' . request('month') . '%');
                })
                ->when(!request()->has('month'), function ($query) {
                    $query->where('start_date', '>=', date('Y-m-d'))->limit(5);
                })
                ->orderBy('start_date', 'ASC')
                ->get();
            $data['upcoming_events'] = $holidays->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'date' => Carbon::parse($event->start_date)->format('F j'),
                    'day' => Carbon::parse($event->start_date)->format('l'),
                    'start_date' => $this->dateFormatWithoutTime($event->start_date),
                    'attachment_file_id' => uploaded_asset($event->attachment_id),
                ];
            });

            // before check in 
            // "attendance_status": {
            //     "checkin": false,
            //     "checkout": false,
            //     "in_time": null,
            //     "out_time": null,
            //     "stay_time": null
            // }


            // after checkin 
            // "attendance_status": {
            //     "id": 1,
            //     "checkin": true,
            //     "checkout": false,
            //     "in_time": "11:47 AM",
            //     "out_time": null,
            //     "stay_time": null
            // }
            $data['attendance_status'] = resolve(AttendanceRepository::class)->getCheckInCheckoutStatus(Auth::id())->getData()->data;
            $data['break_history_data'] = resolve(EmployeeBreakService::class)->breakBackHistoryStatics($request)->getData()->data;
            $base_settings = resolve(AppSettingsRepository::class)->companyBaseSettings();
            //object to array
            $base_settings = (array)$base_settings->getData()->data;

            unset($base_settings['departments']);
            unset($base_settings['designations']);
            unset($base_settings['employee_types'], $base_settings['permissions']);

            $data['config'] = $base_settings;
            $this_month_notice = resolve(NoticeRepository::class)->currentMonthNotice();

            //this_month_notice push to data['config']
            $data['config']['total_notice'] = $this_month_notice;

            $report_permission = "false";
            if (hasPermission('report') || hasPermission('report_menu')) {
                $report_permission = "true";
            }
            $menus = AppScreen::where('status_id', 1)->orderBy('position', 'ASC')
                ->select('name', 'slug', 'position', 'icon')
                ->when($report_permission == "false", function ($query) {
                    return $query->where('slug', '!=', 'report');
                })
                ->get();
            foreach ($menus as $menu) {
                $image_type = pathinfo($menu->icon, PATHINFO_EXTENSION);
                $menu->image_type = $image_type;
                $menu->icon = my_asset($menu->icon);
            }
            $data['menus'] = $menus;

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    public function getDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];

            $screen_data =  AppScreen::where('status_id', 1)->pluck('slug')->toArray();
            if (in_array('appointments', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('appoinment')),
                    'title' => 'Appointments',
                    'slug' => 'appointment',
                    'number' => Appoinment::where('date', $date)
                        ->where(function ($query) {
                            $query->where('created_by', auth()->user()->id)
                                ->orWhere('appoinment_with', auth()->user()->id);
                        })
                        ->count(),
                ];
            }

            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('meeting')),
                'title' => 'Meetings',
                'slug' => 'meeting',
                'number' => Meeting::where('date', $date)->where('user_id', auth()->user()->id)->count(),
            ];
            if (in_array('visit', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('visit')),
                    'title' => 'Visit',
                    'slug' => 'visit',
                    'number' => Visit::where('date', $date)->where('user_id', auth()->user()->id)->count(),
                ];
            }

            if (in_array('support', $screen_data)) {
                $data['today'][] = [
                    'image' => global_asset($this->getStatisticsImage('support')),
                    'title' => 'Support Tickets',
                    'slug' => 'support_ticket',
                    'number' => SupportTicket::where('date', $date)
                        ->where('user_id', auth()->user()->id)
                        ->orWhere('assigned_id', auth()->user()->id)
                        ->where('status_id', 1)
                        ->where('type_id', 12)
                        ->count(),
                ];
            }
            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->singleAttendanceSummary(auth()->user(), $request);

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('late')),
                'title' => 'Late In',
                'slug' => 'late_in',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            if (in_array('leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('leave')),
                    'title' => 'Leave',
                    'slug' => 'leave',
                    'number' => str_replace(' days', '', $attendance_data['total_leave']),
                ];
            }
            if (in_array('daily-leave', $screen_data)) {
                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('early-leave')),
                    'title' => 'Early Leave',
                    'slug' => 'early_leave',
                    'number' => str_replace(' days', '', $attendance_data['total_left_early']),
                ];
            }
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('absent')),
                'title' => 'Absent',
                'slug' => 'absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            if (in_array('visit', $screen_data)) {

                $data['current_month'][] = [
                    'image' => global_asset($this->getStatisticsImage('visit')),
                    'title' => 'Visits',
                    'slug' => 'visits',
                    'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                        ->where('user_id', auth()->user()->id)
                        ->count(),
                ];
            }

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('rewards')),
                'title' => 'Rewards',
                'slug' => 'rewards',
                'number' => \App\Models\Award\Award::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                    ->where('user_id', auth()->user()->id)
                    ->count(),
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getSuperadminDashboardStatistic($request)
    {
        try {

            $date = date('Y-m');

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('employee')),
                'title' => 'Total Company',
                'slug' => 'total_company',
                'number' => Company::where('id', '!=', 1)->count(),
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
    function new_income_expense($request)
    {
        $date = date('Y-m-d');
        $time = explode('-', $date);
        $year = $time[0];
        $month = $time[1];
    }

    public function getCompanyDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];



            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('employee')),
                'title' => 'Total Employees',
                'number' => number_format(User::where('company_id', auth()->user()->company->id)->where('role_id', '!=', 1)->count()),
            ];
            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('expense')),
                'title' => 'Total Expenses',
                'number' => number_format(PaymentHistory::where('company_id', auth()->user()->company->id)->count()),
            ];
            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('meeting')),
                'title' => 'Total Meetings',
                'number' => number_format(Meeting::where('company_id', auth()->user()->company->id)->count()),
            ];

            $data['today'][] = [
                'image' => global_asset($this->getStatisticsImage('support')),
                'title' => 'Support Tickets',
                'number' => number_format(SupportTicket::where('status_id', 1)
                    ->where('company_id', auth()->user()->company->id)
                    ->count()),
            ];



            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->monthlyAttendanceSummary(auth()->user(), $request);

            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('late')),
                'title' => 'Late In',
                'slug' => 'late_in',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('leave')),
                'title' => 'Leave',
                'slug' => 'leave',
                'number' => str_replace(' days', '', $attendance_data['total_leave']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('early-leave')),
                'title' => 'Early Leave',
                'slug' => 'early_leave',
                'number' => str_replace(' days', '', $attendance_data['total_left_early']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('absent')),
                'title' => 'Absent',
                'slug' => 'absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('visit')),
                'title' => 'Visits',
                'slug' => 'visits',
                'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                    ->where('user_id', auth()->user()->id)
                    ->count(),
            ];

            $data['current_month'][] = [
                'image' => global_asset($this->getNewStatisticsImage('rewards')),
                'title' => 'Rewards',
                'slug' => 'rewards',
                'number' => "0"
            ];


            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getCompanyDashboardCurrentMonthStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            $date = $time[2];



            //Current Month
            $request['month'] = null;
            $attendance_data = $this->attendanceReportRepository->companyAttendanceSummary(auth()->user(), $request);
            $data['all_data'][] = [
                'data' => $attendance_data,
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('late')),
                'title' => 'Late In',
                'number' => str_replace(' days', '', $attendance_data['total_late_in']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('leave')),
                'title' => 'Leave',
                'number' => str_replace(' days', '', $attendance_data['total_leave']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('early-leave')),
                'title' => 'Early Leave',
                'number' => str_replace(' days', '', $attendance_data['total_left_early']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('absent')),
                'title' => 'Absent',
                'number' => str_replace(' days', '', $attendance_data['absent']),
            ];
            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('visit')),
                'title' => 'Visits',
                'number' => Visit::where('date', 'LIKE', '%' . $year . '-' . $month . '%')
                    ->count(),
            ];

            $data['current_month'][] = [
                'image' => global_asset($this->getStatisticsImage('rewards')),
                'title' => 'Rewards',
                'number' => "0"
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }


    public function currentMonthPieChart($request)
    {
        $data = [];
        $totalPresent = 0;
        $totalAbsent = 0;
        $totalLeave = 0;
        $totalOnTimeIn = 0;
        $totalLateIn = 0;
        $totalLeftTimely = 0;
        $totalLeftEarly = 0;
        if ($request->month) {
            $monthArray = $this->getSelectedMonthDays($request->month);
        } else {
            $monthArray = $this->getCurrentMonthDays();
        }

        foreach ($monthArray as $day) {

            $todayDateInSqlFormat = $day->format('Y-m-d');
            $leaveDate = LeaveRequest::where(['company_id' => $this->companyInformation()->id, 'user_id' => auth()->id(), 'status_id' => 1])
                ->where('leave_from', '<=', $todayDateInSqlFormat)
                ->where('leave_to', '>=', $todayDateInSqlFormat)
                ->first();

            if ($leaveDate) {
                $totalLeave += 1;
            }
            $attendance = $this->attendance->query()->where(['user_id' => auth()->id(), 'date' => $todayDateInSqlFormat])->first();
            if ($attendance) {
                $totalPresent += 1;
                if ($attendance->in_status == AttendanceStatus::ON_TIME) {
                    $totalOnTimeIn += 1;
                } elseif ($attendance->in_status == AttendanceStatus::LATE) {
                    $totalLateIn += 1;
                } else {
                    $totalOnTimeIn += 1;
                }

                if ($attendance->check_out) {
                    if ($attendance->out_status == AttendanceStatus::LEFT_TIMELY || $attendance->out_status == AttendanceStatus::LEFT_LATER) {
                        $totalLeftTimely += 1;
                    } elseif ($attendance->out_status == AttendanceStatus::LEFT_EARLY) {
                        $totalLeftEarly += 1;
                    } else {
                        $totalLeftTimely += 1;
                    }
                }
            } else {
                $totalAbsent += 1;
            }
        }

        $data['leave early'] = $totalLeftEarly;
        $data['on time'] = $totalOnTimeIn;
        $data['late'] = $totalLateIn;
        $data['leave'] = $totalLeave;
        $chartArray = [];
        foreach ($data as $key => $item) {
            if ($key === 'leave early') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
            if ($key === 'leave') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
            if ($key === 'late') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
            if ($key === 'on time') {
                $chartArray['series'][] = $item;
                $chartArray['labels'][] = $key;
            }
        }
        return $this->responseWithSuccess('Pie chart', $chartArray, 200);
    }

    // new functions

    function getProjectDashboard($id = null)
    {
        if (@$id) {
            $data = Project::join('project_membars', 'projects.id', '=', 'project_membars.project_id')
                ->where('project_membars.user_id', auth()->id())
                ->where('projects.company_id', auth()->user()->company_id);
        } else {
            $data = Project::where('company_id', auth()->user()->company_id);
        }
        return [
            [
                'name' => _trans('project.Cancelled'),
                'value' => $data->clone()->where('projects.status_id', 28)->count(),
            ],
            [
                'name' => _trans('project.Completed'),
                'value' => $data->clone()->where('projects.status_id', 27)->count(),
            ],
            [
                'name' => _trans('project.In Progress'),
                'value' => $data->clone()->where('projects.status_id', 26)->count(),
            ],
            [
                'name' => _trans('project.On Hold'),
                'value' => $data->clone()->where('projects.status_id', 25)->count(),
            ],
            [
                'name' => _trans('project.Not Started'),
                'value' => $data->clone()->where('projects.status_id', 24)->count(),
            ],
        ];
    }

    function getTaskDashboard($id = null)
    {
        if (@$id) {
            $data = DB::table('tasks')
                ->join('task_members', 'tasks.id', '=', 'task_members.task_id')
                ->where('task_members.user_id', auth()->id())
                ->where('tasks.company_id', auth()->user()->company_id);
        } else {
            $data = DB::table('tasks')->where('company_id', auth()->user()->company_id);
        }
        return [
            [
                'name' => _trans('project.Cancelled'),
                'value' => $data->clone()->where('tasks.status_id', 28)->count(),
            ],
            [
                'name' => _trans('project.Completed'),
                'value' => $data->clone()->where('tasks.status_id', 27)->count(),
            ],
            [
                'name' => _trans('project.In Progress'),
                'value' => $data->clone()->where('tasks.status_id', 26)->count(),
            ],
            [
                'name' => _trans('project.On Hold'),
                'value' => $data->clone()->where('tasks.status_id', 25)->count(),
            ],
            [
                'name' => _trans('project.Not Started'),
                'value' => $data->clone()->where('tasks.status_id', 24)->count(),
            ],
        ];
    }

    function getAppointmentDashboard($id = null)
    {

        try {
            $where = [];
            if (@$id) {
                $where['created_by'] = auth()->id();
            }
            $appointment = $this->appointment->query()->where('company_id', auth()->user()->company_id)->where($where)->where('date', '>=', date('Y-m-d'))->latest()->take(6)->get()->map(function ($data) {
                return [
                    'title' => $data->title,
                    'with' => $data->appoinmentWith->name,
                    'date_time' => showDate($data->date) . ' <small class="badge-basic-success-text"> ' . ($data->appoinment_start_at) . ' - ' . ($data->appoinment_end_at) . '</small>',
                    'location' => $data->location
                ];
            });
            return $this->responseWithSuccess("Dashboard appointment data", $appointment, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    function getMeetingDashboard($id = null)
    {

        try {
            $meeting = $this->meeting->where('company_id', auth()->user()->company_id)->where('date', '>=', date('Y-m-d'))->latest();

            if (@$id) {
                $meeting = $meeting->where('user_id', $id)->whereHas('meetingParticipants', function ($q) {
                    $q->orWhere('user_id', auth()->id());
                });
            }

            $meeting = $meeting->take(6)->get()->map(function ($data) {
                return [
                    'title' => $data->title,
                    'with' => teams($data->meetingParticipants),
                    'date_time' =>  @$data->start_at ? showDate($data->date) . ' <small class="badge-basic-success-text"> ' . ($data->start_at) . ' - ' . ($data->end_at) . '</small>' : showDate($data->date),
                    'location' => $data->location
                ];
            });
            return $this->responseWithSuccess("Dashboard meeting data", $meeting, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
    // public function getNewDashboardStatistics($request)
    // {
    //     try {

    //         $date = date('Y-m-d');
    //         $time = explode('-', $date);
    //         $year = $time[0];
    //         $month = $time[1];
    //         // $date = $time[2];


    //         // $data['today'][] = [
    //         //     'image' => $this->getNewStatisticsImage('project'),
    //         //     'title' => _trans('dashboard.Total Projects'),
    //         //     'color_class' => 'circle-primary',
    //         //     $project = DB::table('projects')
    //         //         ->join('project_membars', 'projects.id', '=', 'project_membars.project_id')
    //         //         ->where('project_membars.user_id', auth()->id())
    //         //         ->where('projects.company_id', auth()->user()->company_id)
    //         //         ->count(),
    //         //     'number' => (number_format_short($project)),
    //         // ];
    //         // $data['today'][] = [
    //         //     'image' => $this->getNewStatisticsImage('tasks'),
    //         //     'title' => _trans('dashboard.Total Tasks'),
    //         //     'color_class' => 'circle-warning',
    //         //     $task  = DB::table('tasks')
    //         //         ->join('task_members', 'tasks.id', '=', 'task_members.task_id')
    //         //         ->where('task_members.user_id', auth()->id())
    //         //         ->where('tasks.company_id', auth()->user()->company_id)
    //         //         ->count(),
    //         //     'number' => (number_format_short($task)),

    //         // ];
    //         // $data['today'][] = [
    //         //     'image' => $this->getNewStatisticsImage('visit'),
    //         //     'title' => _trans('dashboard.Total Visit'),
    //         //     'color_class' => 'circle-lightseagreen',
    //         //     'number' => number_format_short(DB::table('visits')->where('company_id', auth()->user()->company_id)->where('user_id', auth()->id())->count()),
    //         // ];
    //         // $data['today'][] = [
    //         //     'image' => $this->getNewStatisticsImage('appointment'),
    //         //     'title' => _trans('dashboard.Total Appointments'),
    //         //     'color_class' => 'circle-danger',
    //         //     'number' => number_format_short(DB::table('appoinments')->where('company_id', auth()->user()->company_id)->where('created_by', auth()->id())->count()),
    //         // ];

    //         $monthlySummary = $this->attendanceReportRepository->singleAttendanceSummary(auth()->user(), $request);

    //         $workingDays = str_replace(' days', '',$monthlySummary['working_days']);
    //         $present = str_replace(' days', '',$monthlySummary['present']);
    //         $workingTime = str_replace(' min', '',$monthlySummary['work_time']);
    //         $workingTimePerHour = ($workingTime/60);
    //         $totalWorkingHours = $workingDays * 9;

    //         $basicSalary = auth()->user()->basic_salary;
    //         $salaryPerDay = $basicSalary/$workingDays;
    //         $salaryPerHours = $salaryPerDay/9;
    //         $totalSalary = $salaryPerHours * $workingTimePerHour;

    //         $data['today'][] = [
    //             'image' => $this->getNewStatisticsImage('project'),
    //             'title' => _trans('dashboard.Total Working Hours'),
    //             'color_class' => 'circle-primary',
    //             'number' => $workingTimePerHour . " H/{$totalWorkingHours}",
    //         ];

    //         $data['today'][] = [
    //             'image' => $this->getNewStatisticsImage('project'),
    //             'title' => _trans('dashboard.Present Days'),
    //             'color_class' => 'circle-primary',
    //             'number' => $present.'/'.$workingDays,
    //         ];

    //         $data['today'][] = [
    //             'image' => $this->getNewStatisticsImage('project'),
    //             'title' => _trans('dashboard.Salary'),
    //             'color_class' => 'circle-primary',
    //             'number' => $totalSalary,
    //         ];

    //         return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
    //     } catch (\Throwable $exception) {
    //         return $this->responseWithError($exception->getMessage(), [], 500);
    //     }
    // }

    public function getNewDashboardStatistics($request)
    {
        try {
            $monthlySummary = $this->attendanceReportRepository->singleAttendanceSummaryEmployee(auth()->user(), $request);

            // Extracting data and converting to appropriate types
            $workingDays = (int)str_replace(' days', '', $monthlySummary['working_days']);
            $present = (int)str_replace(' days', '', $monthlySummary['present']);
            $workingTimeInMinutes = (int)str_replace(' min', '', $monthlySummary['work_time']);

            // Avoid division by zero for working days
            if ($workingDays == 0) {
                $workingDays = 1;
            }

            // Correctly calculate hours and minutes
            $totalWorkedHours = floor($workingTimeInMinutes / 60);
            $totalWorkedMinutes = $workingTimeInMinutes % 60;
            $totalWorkingHours = round($workingDays * 9, 2);

            // Salary Calculations
            $basicSalary = auth()->user()->basic_salary ?? 0;
            $salaryPerDay = round($basicSalary / $workingDays, 2);
            $salaryPerHour = round($salaryPerDay / 9, 2);

            // Include minutes in salary calculation for more accuracy
            $totalSalary = round($salaryPerHour * $totalWorkedHours + ($salaryPerHour / 60) * $totalWorkedMinutes, 2);

            // Prepare data for response
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('project'),
                'title' => _trans('dashboard.Present Days'),
                'color_class' => 'circle-primary',
                'number' => "$present / $workingDays",
            ];

            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('project'),
                'title' => _trans('dashboard.Total Working Hours'),
                'color_class' => 'circle-primary',
                'number' => "{$totalWorkedHours} H {$totalWorkedMinutes} min / {$totalWorkingHours} H",
            ];

            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('project'),
                'title' => _trans('dashboard.Salary'),
                'color_class' => 'circle-primary',
                'number' => "Rs " . number_format($totalSalary, 2),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('payroll'),
                'title' => _trans('dashboard.Payslip'),
                'color_class' => 'circle-primary',
                // 'number' => "Rs " . number_format($totalSalary, 2),
            ];

            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            Log::error('Dashboard Statistics Error: ' . $exception->getMessage());
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }

    public function getNewCompanyDashboardStatistics($request)
    {
        try {

            $date = date('Y-m-d');
            $time = explode('-', $date);
            $year = $time[0];
            $month = $time[1];
            // $date = $time[2];
            \Illuminate\Support\Facades\App::setLocale(userLocal());

            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('employee'),
                'color_class' => 'circle-violet',
                'title' => _trans('dashboard.Total Employees'),
                'number' => number_format_short(User::where('company_id', auth()->user()->company->id)->where('status_id', 1)->where('role_id', '!=', 1)->where('branch_id', userBranch())->count()),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('client'),
                'color_class' => 'circle-hotpink',
                'title' => _trans('dashboard.Total Clients'),
                'number' => number_format_short(Client::where('company_id', auth()->user()->company->id)->count()),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('expense'),
                'title' => _trans('dashboard.Total Expenses'),
                'color_class' => 'circle-brown',
                'number' => showAmount(number_format(Expense::where('company_id', auth()->user()->company_id)->where('pay', 8)->where('status_id', 5)->sum('amount'))),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('deposit'),
                'title' => _trans('dashboard.Total Deposits'),
                'color_class' => 'circle-success',
                'number' => showAmount(number_format(Deposit::where('company_id', auth()->user()->company_id)->where('pay', 8)->where('status_id', 5)->sum('amount'))),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('project'),
                'title' => _trans('dashboard.Total Projects'),
                'color_class' => 'circle-primary',
                'number' => (number_format_short(Project::where('company_id', auth()->user()->company_id)->count())),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('tasks'),
                'title' => _trans('dashboard.Total Tasks'),
                'color_class' => 'circle-warning',
                'number' => (number_format_short(Task::where('company_id', auth()->user()->company_id)->count())),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('visit'),
                'title' => _trans('dashboard.Total Visit'),
                'color_class' => 'circle-lightseagreen',
                // 'number' => Visit::where('date', 'LIKE', '%' . $date . '%')->count(),
                'number' => number_format_short(Visit::where('company_id', auth()->user()->company_id)->count()),
            ];
            $data['today'][] = [
                'image' => $this->getNewStatisticsImage('appointment'),
                'title' => _trans('dashboard.Total Appointments'),
                'color_class' => 'circle-danger',
                'number' => number_format_short(Appoinment::where('company_id', auth()->user()->company_id)->count()),
            ];


            return $this->responseWithSuccess("Dashboard Statistics Data", $data, 200);
        } catch (\Throwable $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
}
