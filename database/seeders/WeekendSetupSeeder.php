<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hrm\Attendance\Weekend;

class WeekendSetupSeeder extends Seeder
{
    public function run()
    {
        $weekdays = [
            'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
        ];

        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;

        foreach ($weekdays as $weekday) {
            $isWeekend = in_array($weekday, ['saturday', 'sunday']) ? 'yes' : 'no';

            Weekend::create([
                'company_id' => $company_id,
                'name' => $weekday,
                'status_id' => 1,
                'branch_id' => $branch_id,
                'is_weekend' => $isWeekend,
            ]);
        }
    }
}
