<?php

namespace Database\Seeders\Hrm;

use App\Models\Hrm\Leave\LeaveSetting;
use Illuminate\Database\Seeder;

class LeaveSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   
        $leave_setting = LeaveSetting::where('company_id', 1)->first();
        if (!$leave_setting) {
            $leave_setting = new LeaveSetting;
            $leave_setting->sandwich_leave = 0;
            $leave_setting->month = 1;
            $leave_setting->prorate_leave = 0;
            $leave_setting->company_id = 1;
            $leave_setting->branch_id = 1;
            $leave_setting->save(); 

        }

    }
}
