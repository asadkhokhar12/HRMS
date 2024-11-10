<?php

namespace Modules\OfflineBasedAttendance\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\AttendanceStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Hrm\Attendance\Attendance;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Models\Hrm\Attendance\DutySchedule;
use App\Models\Hrm\Attendance\LateInOutReason;
use App\Helpers\CoreApp\Traits\GeoLocationTrait;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;

class AttendanceRepository
{
    use ApiReturnFormatTrait, RelationshipTrait, TimeDurationTrait, GeoLocationTrait, DateHandler, FileHandler;

    protected $attendance;
    protected $user;

    public function __construct(Attendance $attendance, User $user) {
        $this->attendance = $attendance;
        $this->user = $user;
    }

    public function storeOffline($requestData)
    {
        $validator = Validator::make($requestData, [
            '*.date' => 'required|date',
        ],[
            '*.date.required'   => __('Date is required'),
            '*.date.date'       => __('Invalid date format'),
        ]);
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        
        try {
            foreach($requestData as $value){
                $request['latitude']        = $value['latitude'];
                $request['longitude']       = $value['longitude'];
                $request['date']            = $value['date'];
                $request['remote_mode']     = $value['remote_mode'];
                $request['selfie_image']    = $value['selfie_image'];
                $request['reason']          = $value['reason'];
                if ($value['inTime']) {
                    $carbonTime             = Carbon::parse($value['inTime']);
                    $formattedTime          = $carbonTime->format('H:i');
                    $request['in_time']     = $formattedTime;
                    $user = $this->user->query()->with('company')->find(Auth::id());
                    $getLastAttendanceId = $this->checkinOffline($user, $request);
                } 
                if ($value['outTime']) {
                    if(@$getLastAttendanceId){
                        $attendanceId        = $getLastAttendanceId;
                    } else{
                        $attendanceId        = null;
                    }
                    $carbonTime             = Carbon::parse($value['outTime']);
                    $formattedTime          = $carbonTime->format('H:i');
                    $request['out_time']     = $formattedTime;
                    $this->checkOutOffline($request, $attendanceId);
                }
            }
            return $this->responseWithSuccess('Attendance done successfully', [], 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong.'), [$th->getMessage()], 400);
        }
    }

    public function checkinOffline($user, $request)
    {
        if ($user) {
            $attendance = $this->attendance->with('user')->where(['user_id' => $user->id, 'date' => $request['date']])->first();
            if ($attendance && !settings('multi_checkin')) {
                return $this->responseWithError('Attendance already exists', [], 200);
            }
            $attendance_status = $this->checkInStatus($user->id, $request['in_time']);
            if (count($attendance_status) > 0) {
                $current_date_time = $request['date']." ".$request['in_time'].":00";
                $check_in = new $this->attendance;
                $check_in->company_id = $user->company->id;
                $check_in->user_id = $user->id;
                $check_in->remote_mode_in = $request['remote_mode'];
                $check_in->date = $request['date'];
                // selfie based attendance check in
                if ($request['selfie_image']) {
                    $filePath = $this->uploadImage($request['selfie_image'], 'uploads/attendance');
                    $check_in->check_in_image = $filePath ? $filePath->id : null;
                }
                $check_in->check_in = $current_date_time;
                $check_in->in_status = $attendance_status[0];
                $check_in->late_time = $attendance_status[1];
                $check_in->check_in_location = getGeocodeData($request['latitude'], $request['longitude']);
                $check_in->check_in_latitude = $request['latitude'];
                $check_in->check_in_longitude = $request['longitude'];

                $attendanceCloneCheck = $this->attendance->with('user')->where(['user_id' => $user->id, 'check_in' => $current_date_time])->first();
                if(!$attendanceCloneCheck){
                    $check_in->save();
                    if ($request['reason']) {
                        LateInOutReason::create([
                            'attendance_id' => $check_in->id,
                            'user_id' => $check_in->user_id,
                            'company_id' => $check_in->user->company->id,
                            'type' => 'in',
                            'reason' => $request['reason']
                        ]);
                    }
                }
                
                return $check_in->id;
            } else {
                return $this->responseWithError('No Schedule found', [], 200);
            }
        } else {
            return $this->responseWithError('No user found', [], 200);
        }
    }

    public function checkOutOffline($request, $id)
    {
        try {
            if(!$id){   // no in_time (just check out)
                $attendance_status = $this->checkOutStatus(Auth::id(), $request['out_time']);
                if (count($attendance_status) > 0) {
                    $current_date_time = $request['date']." ".$request['out_time'].":00";
                    $check_in = new $this->attendance;
                    $check_in->user_id              = Auth::id();
                    $check_in->date                 = $request['date'];
                    $check_in->remote_mode_out      = $request['remote_mode'];
                    $check_in->check_out            = $current_date_time;
                    $check_in->out_status           = $attendance_status[0];
                    $check_in->late_time            = $attendance_status[1];
                    $check_in->check_out_location   = getGeocodeData($request['latitude'], $request['longitude']);
                    $check_in->check_out_latitude   = $request['latitude'];
                    $check_in->check_out_longitude  = $request['longitude'];
                     // selfie based attendance check out
                     if ($request['selfie_image']) {
                        $filePath = $this->uploadImage($request['selfie_image'], 'uploads/attendance');
                        $check_in->check_out_image = $filePath ? $filePath->id : null;
                    }

                    $attendanceCloneCheck = $this->attendance->with('user')->where(['user_id' => $user->id, 'check_out' => $current_date_time])->first();
                    if(!$attendanceCloneCheck){
                        $check_in->save();
                        if ($request['reason']) {
                            LateInOutReason::create([
                                'attendance_id' => $check_in->id,
                                'user_id' => $check_in->user_id,
                                'company_id' => $check_in->user->company->id,
                                'type' => 'out',
                                'reason' => $request['reason']
                            ]);
                        }
                    }
                }
            } else{  // get in_time (then check out)
                $check_in = $this->attendance->query()->find($id);
                if ($check_in && $check_in->check_out) {
                    return $this->responseWithError('Checkout has already been done', [], 200);
                }
                $user = $this->user->query()->find(Auth::id());
                if ($user) {
                    $attendance_status = $this->checkOutStatus(Auth::id(), $request['out_time']);
                    if (count($attendance_status) > 0) {
                        $current_date_time = $request['date']." ".$request['out_time'].":00";
                        if ($check_in) {
                            $check_in->user_id              = Auth::id();
                            $check_in->remote_mode_out      = $request['remote_mode'];
                            $check_in->check_out            = $current_date_time;
                            $check_in->out_status           = $attendance_status[0];
                            $check_in->late_time            = $attendance_status[1];
                            $check_in->check_out_location   = getGeocodeData($request['latitude'], $request['longitude']);
                            $check_in->check_out_latitude   = $request['latitude'];
                            $check_in->check_out_longitude  = $request['longitude'];
                            // selfie based attendance check out
                            if ($request['selfie_image']) {
                                $filePath = $this->uploadImage($request['selfie_image'], 'uploads/attendance');
                                $check_in->check_out_image = $filePath ? $filePath->id : null;
                            }
                            $check_in->save();

                            if ($request['reason']) {
                                LateInOutReason::create([
                                    'attendance_id' => $check_in->id,
                                    'user_id' => $check_in->user_id,
                                    'company_id' => $check_in->user->company->id,
                                    'type' => 'out',
                                    'reason' => $request['reason']
                                ]);
                            }
                        } else {
                            return $this->responseWithError('No data found', [], 200);
                        }
                    } else {
                        return $this->responseWithError('No Schedule found', [], 200);
                    }
                } else {
                    return $this->responseWithError('No user found', [], 200);
                }
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(_trans('response.Something went wrong.'), [], 200);
        }
    }
    


    public function locationCheck($request)
    {
        $locationInfo = false;
        foreach (DB::table('location_binds')->where('company_id', $this->companyInformation()->id)->where('status_id', 1)->get() as $location) {
            $distance = distanceCalculate($request->latitude, $request->longitude, $location->latitude, $location->longitude);
            if ($distance <= $location->distance) {
                $locationInfo = true;
            }
        }
        return $locationInfo;
    }
    
    public function checkInStatus($user_id, $check_in_time): array
    {
        /*
         *  OT = On time
         * E = Early
         * L = Late
         */
        $user_info = User::find($user_id);
        $schedule = DutySchedule::where('shift_id', $user_info->shift_id)->where('status_id', 1)->first();
        if ($schedule) {
            $startTime = strtotime($schedule->start_time);
            $check_in_time = strtotime($check_in_time . ':00');
            $diffFromStartTime = ($check_in_time - $startTime) / 60;
            //check employee check-in on time
            if ($check_in_time <= $startTime) {
                return [AttendanceStatus::ON_TIME, $diffFromStartTime];
            } else {
                $considerTime = $schedule->consider_time;
                // check if employee come late and have some consider time
                if ($diffFromStartTime > $considerTime) {
                    return [AttendanceStatus::LATE, $diffFromStartTime];
                } else {
                    return [AttendanceStatus::ON_TIME, $diffFromStartTime];
                }
            }
        } else {
            return array();
        }
    }

    public function checkOutStatus($user_id, $check_out_time): array
    {
        /*
         *  LE = Left Early
         *  LT = Left Timely
         *  LL = Left Later
         */
        $user_info = User::find($user_id);
        $schedule = DutySchedule::where('shift_id', $user_info->shift_id)->first();
        if ($schedule) {
            $endTime = strtotime($schedule->end_time);
            $formate = [
                'check_out_time' => $check_out_time,
                'endTime' => $schedule->end_time
            ];
            $check_out_time = strtotime($formate['check_out_time']);
            $endTime = strtotime($formate['endTime']);
            $diffFromEndTime = ($endTime - $check_out_time) / 60;
            //check employee check-out after end time
            if ($check_out_time > $endTime) {
                return [AttendanceStatus::LEFT_LATER, $diffFromEndTime];
            } //check employee check-out timely
            elseif ($check_out_time == $endTime) {
                return [AttendanceStatus::LEFT_TIMELY, $diffFromEndTime];
            } //check employee check-out before end time
            elseif ($check_out_time < $endTime) {
                return [AttendanceStatus::LEFT_EARLY, $diffFromEndTime];
            } //in general an employee check-out timely
            else {
                return [AttendanceStatus::LEFT_TIMELY, $diffFromEndTime];
            }
        } else {
            return array();
        }
    }
    
}
