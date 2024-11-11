<?php

namespace Database\Seeders\Hospital;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;

        $departments = [
            'Management',
            'IT',
            'Sales',
            'Emergency Medicine',
            'Human Resources',
            'Finance',
            'Marketing',
            'Patient Services',
            'Customer Service',
            'Purchasing',
            "Cardiology",
            "Orthopedics",
            "Pediatrics",
            "Neurology",
            "Oncology",
            "Gastroenterology",
            "Radiology",
            "Dermatology",
            "Emergency Medicine",
            "Internal Medicine",
        ];

        $departmentData = [];

        foreach ($departments as $key => $department) {
            $departmentData[] = [
                'title' => $department,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => 1,
            ];
        }
        DB::table('departments')->insert($departmentData);

        if ($input) {
            $lastDepartmentId = DB::table('departments')->pluck('id')->last();
            $input['department_id'] = $lastDepartmentId;
            session()->put('input', $input);
        }
    }
}
