<?php

namespace App\Http\Controllers;

use App\Models\DeviceLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jmrashed\Zkteco\Lib\ZKTeco;
use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Models\Hrm\Attendance\Attendance;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class ZKtecoController extends Controller
{
    public function zkteco()
    {
        try {

            date_default_timezone_set('Asia/Karachi');

            $zk = new ZKTeco('192.168.50.201');
            $zk->connect();
            $attendanceLog = $zk->getAttendance();
            // dd($attendanceLog);
            // Filter attendance records for today
            $todayRecords = [];
            foreach ($attendanceLog as $record) {
                $todayRecords[] = [
                    'employee_id' => $record['id'],
                    'timestamp' => $record['timestamp'],
                    'state' => $record['state'],
                    'type' => $record['type'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            DeviceLog::insert($todayRecords);
            dd('Device log added successfully');
        } catch (\Throwable $th) {
            dd('error : ', $th);
            throw $th;
        }
    }

    public function storeAttendance($employeeId)
    {
        // Retrieve logs from the device_log table
        $logs = DB::table('device_logs')->where('employee_id', $employeeId)->get();

        foreach ($logs as $log) {
            // Extract necessary fields
            $employeeId = $log->employee_id;
            $timestamp = $log->timestamp;
            $type = $log->type;

            // Find the user with the given employee_id
            $user = User::where('employee_id', $employeeId)->first();

            if (!$user) {
                // If no user found with this employee_id, skip this log entry
                continue;
            }

            // Get the date part from the timestamp
            $date = Carbon::parse($timestamp)->format('Y-m-d');

            // Retrieve the first Check-In and last Check-Out for this user on this date
            $firstCheckIn = DB::table('device_logs')
                ->where('employee_id', $employeeId)
                ->whereDate('timestamp', $date)
                ->where('type', 0)  // Check-In type
                ->orderBy('timestamp', 'asc')
                ->first();

            $lastCheckOut = DB::table('device_logs')
                ->where('employee_id', $employeeId)
                ->whereDate('timestamp', $date)
                ->where('type', 1)  // Check-Out type
                ->orderBy('timestamp', 'desc')
                ->first();

            // Prepare the attendance data
            $attendanceData = [
                'user_id' => $user->id,
                'date' => $date,
                'check_in' => $firstCheckIn?->timestamp,
                'check_out' => $lastCheckOut?->timestamp,
            ];

            // Check if an attendance record exists for the user and date
            $attendance = DB::table('machine_attendances')
                ->where('user_id', $user->id)
                ->whereDate('date', $date)
                ->first();

            if ($attendance) {
                // Update existing attendance record
                DB::table('machine_attendances')
                    ->where('user_id', $user->id)
                    ->whereDate('date', $date)
                    ->update($attendanceData);
            } else {
                // Insert new attendance record
                DB::table('machine_attendances')->insert($attendanceData);
            }
        }

        // dd("Done");

        // Toastr::success('Attendance records updated successfully', 'Success');
        // return redirect()->route('attendance.index');
    }


    // public function processAttendanceLog()
    // {
    //     date_default_timezone_set('Asia/Karachi');

    //     // Assuming you have retrieved the attendance log from ZKTeco
    //     $zk = new ZKTeco('192.168.50.200');
    //     $zk->connect();
    //     $attendanceLog = $zk->getAttendance();

    //     foreach ($attendanceLog as $record) {
    //         $employeeId = $record['id'];
    //         $timestamp = $record['timestamp'];
    //         $type = $record['type'];

    //         // Find the user with the given employee ID
    //         $user = User::where('employee_id', $employeeId)->first();

    //         if ($user) {
    //             $date = Carbon::parse($timestamp)->toDateString();

    //             // Check if an attendance record exists for this user and date
    //             $attendance = Attendance::where('user_id', $user->id)
    //                 ->whereDate('date', $date)
    //                 ->first();

    //             if (!$attendance) {
    //                 // If no record exists for this date, create a new one
    //                 $attendance = new Attendance();
    //                 $attendance->user_id = $user->id;
    //                 $attendance->date = $date;
    //             }

    //             // Set check-in and check-out times based on type
    //             if ($type == 0) { // Check-in
    //                 // Set the check-in time if not already set or if this timestamp is earlier
    //                 if (!$attendance->checkin || Carbon::parse($timestamp)->lt(Carbon::parse($attendance->checkin))) {
    //                     $attendance->checkin = $timestamp;
    //                 }
    //             } elseif ($type == 1) { // Check-out
    //                 // Set the check-out time if this timestamp is later than the existing one
    //                 if (!$attendance->checkout || Carbon::parse($timestamp)->gt(Carbon::parse($attendance->checkout))) {
    //                     $attendance->checkout = $timestamp;
    //                 }
    //             }

    //             // Save or update the attendance record
    //             $attendance->save();
    //         }
    //     }

    //     dd('Attendance log processed successfully');
    // }


    // public function getUser()
    // {
    //     date_default_timezone_set('Asia/Karachi');

    //     $zk = new ZKTeco('192.168.50.200');
    //     $zk->connect();
    //     $attendanceLog = $zk->getUser();
    //     dd($attendanceLog); // Uncomment to check the structure of the returned data if needed

    //     $todayRecords = [];
    //     $existingUserIds = User::pluck('userId')->toArray(); // Retrieve existing user IDs from the users table

    //     foreach ($attendanceLog as $record) {
    //         if (!in_array($record['uid'], $existingUserIds)) {
    //             $todayRecords[] = [
    //                 'device_user_id' => $record['uid'],
    //                 'name' => $record['name'],
    //                 'country_id' => '223',
    //                 'permissions' => json_encode($this->staffPermissions()),
    //                 'created_at' => Carbon::now(),
    //                 'updated_at' => Carbon::now(),
    //             ];
    //             $existingUserIds[] = $record['uid']; // Add to prevent duplicates in the loop
    //         }
    //     }

    //     // Insert new users into the users table if any new records are found
    //     if (!empty($todayRecords)) {
    //         User::insert($todayRecords);
    //     }

    //     dd('New users added successfully');
    // }

}
