<?php

namespace Database\Seeders\Hospital;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Leave\LeaveRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('id', '!=', 1)->select('id', 'department_id')->get();


        foreach ($users ?? [] as $user) {

            $assignLeave = AssignLeave::where('department_id', $user->department_id)->first();

            $leaveFrom = Carbon::now()->addDays(rand(1, 30));
            $leaveTo =  $leaveFrom->copy()->addDays(2);
            
            $leaveRequests = [
                [
                    'assign_leave_id' => $assignLeave->id, // Replace with a valid assign_leave_id
                    'user_id' => $user->id, // Replace with a valid user_id
                    'apply_date' => now(),
                    'leave_from' =>$leaveFrom, // Set a random date within the next 30 days
                    'leave_to' => $leaveTo, // Two days added to leave_from
                    'days' => 6,
                    'reason' => 'Vacation',
                    'substitute_id' => 2, // Replace with a valid substitute_id
                    'attachment_file_id' => 1, // Replace with a valid attachment_file_id
                    'status_id' => 2, // Replace with a valid status_id
                    'author_info_id' => 1, // Replace with a valid author_info_id
                    'company_id' => 1,
                    'branch_id' => 1,
                ],
            ];
    
            foreach ($leaveRequests as $leaveRequest) {
                LeaveRequest::create($leaveRequest);
            }
        }
        
    }
}
