<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Performance\Goal;
use Illuminate\Support\Facades\DB;
use App\Models\Performance\GoalType;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // goal type
        $names = ['Employee Experience', 'Objective', 'Target', 'KPI', 'Measure', 'Indicator'];
        foreach ($names as $name) {
           GoalType::create([
                'name' => $name,
                'company_id' => 2,
            ]);
        }

        // goals
        $goals = new Goal();
        $goals->company_id = 1;
        $goals->subject = 'Employee Experience';
        $goals->target = 'Employee Experience';
        $goals->goal_type_id = 1;
        $goals->rating = 0;
        $goals->progress = 1;
        $goals->start_date = date('Y-m-d');
        $goals->end_date = date('Y-m-d', strtotime('+1 year'));
        $goals->created_by = 2;
        $goals->description = "demo description";
        $goals->save();


    }
}
