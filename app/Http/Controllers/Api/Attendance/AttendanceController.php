<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Hrm\EmployeeBreakService;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Repositories\Hrm\Attendance\AttendanceRepository;

class AttendanceController extends Controller
{
    use ApiReturnFormatTrait;

    protected $attendance;
    protected $breakBackService;

    public function __construct(AttendanceRepository $attendanceRepository, EmployeeBreakService $breakBackService)
    {
        $this->attendance = $attendanceRepository;
        $this->breakBackService = $breakBackService;
    }

    public function checkInCheckoutStatus(Request $request)
    {
        return $this->attendance->getCheckInCheckoutStatus(Auth::id());
    }

    public function manageAttendance(Request $request)
    {
        if (!$request['attendance_id']) {
            return $this->checkIn($request);
        } elseif ($request['attendance_id']) {
            $attendanceId = $request->attendance_id;
            return $this->checkOut($request, $attendanceId);
        } else {
            return $this->responseWithError('Invalid request type', [], 400);
        }
    }
    
    public function checkIn(Request $request)
    {
        $request['latitude'] = $request->latitude;
        $request['longitude'] = $request->longitude;
        $request['date'] = date('Y-m-d');
        $request['check_in'] = date('H:i');
        return $this->attendance->store($request);
    }
    
    public function liveLocationStore(Request $request)
    {
        // return $this->responseWithSuccess('Live data stored successfully');
        return $this->attendance->liveLocationStore($request);
    }

    public function lateInOutReason(Request $request, $attendance_id): \Illuminate\Http\JsonResponse
    {
        return $this->attendance->lateInOutReason($request, $attendance_id);
    }

    public function checkOut(Request $request, $id)
    {
        $request['latitude'] = $request->latitude;
        $request['longitude'] = $request->longitude;
        $request['date'] = date('Y-m-d');
        $request['check_out'] = date('H:i');
        return $this->attendance->checkOut($request, $id);
    }

    public function breakBack(Request $request, $slug)
    {
        return $this->breakBackService->breakStartEnd($request, $slug);
    }

    public function breakBackEnd(Request $request)
    {
        return $this->breakBackService->breakBackEnd($request);
    }

    public function breakBackListView()
    {
        return $this->breakBackService->breakBackList();
    }

    public function breakBackHistory(Request $request)
    {
        return $this->breakBackService->breakBackHistory($request);
    }
    public function attendanceFromDevice(Request $request)
    {
        return $this->attendance->attendanceFromDevice($request);
    }
    public function qrStatus(Request $request)
    {
        return $this->attendance->qrStatus($request);
    }
}
