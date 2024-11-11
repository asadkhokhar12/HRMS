<?php

namespace Database\Seeders\Hospital;

use Illuminate\Database\Seeder;
use App\Models\Hrm\Leave\LeaveType;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Department\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::pluck('id');
        $leaveTypes = LeaveType::pluck('id');

        foreach($departments as $department) {
            foreach($leaveTypes as $leaveType) {

                $leaves = [
                    [
                        'type_id' => $leaveType,
                        'days' => 5,
                        'status_id' => 1,
                        'department_id' => $department,
                        'company_id' => 1,
                        'branch_id' => 1,
                    ],
                ];
        
                foreach ($leaves as $leave) {
                    AssignLeave::create($leave);
                }
            }
        }
         
    }
}
