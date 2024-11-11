<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hrm\Attendance\DutySchedule;

class DutyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;

    
        // Create a new DutySchedule instance
        $duty_schedule = new DutySchedule;
        $duty_schedule->company_id = $company_id;
        $duty_schedule->branch_id = $branch_id;
        $duty_schedule->shift_id = 1;
        $duty_schedule->start_time = '10:00:00';
        $duty_schedule->end_time = '18:00:00';
        $duty_schedule->consider_time = '15';
        $duty_schedule->hour = '8';
        $duty_schedule->status_id = 1;
        $duty_schedule->save();

        $duty_schedule = new DutySchedule;
        $duty_schedule->company_id = $company_id;
        $duty_schedule->branch_id = $branch_id;
        $duty_schedule->shift_id = 2;
        $duty_schedule->start_time = '15:00:00';
        $duty_schedule->end_time = '23:00:00';
        $duty_schedule->consider_time = '15';
        $duty_schedule->hour = '8';
        $duty_schedule->status_id = 1;
        $duty_schedule->save();

        $duty_schedule = new DutySchedule;
        $duty_schedule->company_id = $company_id;
        $duty_schedule->branch_id = $branch_id;
        $duty_schedule->shift_id = 3;
        $duty_schedule->start_time = '23:00:00';
        $duty_schedule->end_time = '07:00:00';
        $duty_schedule->consider_time = '15';
        $duty_schedule->hour = '8';
        $duty_schedule->status_id = 1;
        $duty_schedule->save();
    }
}
