<?php

namespace Database\Seeders\Hrm\Shift;

use App\Models\Hrm\Shift\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
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
        $user_id = $input['user_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;
        $status_id = 1;

        $newShift = Shift::create([
            'name' => 'Morning',
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'status_id' => $status_id,
        ]);
        $newShift = Shift::create([
            'name' => 'Evening',
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'status_id' => $status_id,
        ]);
        $newShift = Shift::create([
            'name' => 'Night',
            'company_id' => $company_id,
            'branch_id' => $branch_id,
            'status_id' => $status_id,
        ]);

        if ($input) {
            $input['shift_id'] = $newShift->id;
            session()->put('input', $input);
        }
    }
}
