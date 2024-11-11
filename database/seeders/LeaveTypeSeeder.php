<?php

namespace Database\Seeders;

use App\Models\Hrm\Leave\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave_types = [
            'Casual Leave',
            'Sick Leave',
            'Maternity Leave',
            'Paternity Leave',
            'Leave Without Pay',
        ];
        if ($input = session()->get('input')) {
            $company_id = $input['company_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;

            session()->put('input', $input);
        } else {
            $company_id = 1;
            $branch_id = 1;
        }
        foreach ($leave_types as $leave_type) {
            $s = new LeaveType();
            $s->company_id = $company_id;
            $s->branch_id = $branch_id;
            $s->name = $leave_type;
            $s->status_id = 1;
            $s->save();
        }

    }
}
