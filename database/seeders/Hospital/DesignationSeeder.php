<?php

namespace Database\Seeders\Hospital;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationSeeder extends Seeder
{
    public function run()
    {
        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;
        
        $designations = [
            'Chairman',
            'Managing Director',
            'HR Manager',
            'IT Manager',
            'Doctor',
            'Nurse',
            'Surgeon',
            'Pharmacist',
            'Radiologist',
            'Laboratory Technician',
            'Administrator',
            'Paramedic',
            'Physiotherapist',
            'Occupational Therapist',
            'Dietitian',
            'Medical Technologist',
            'Anesthesiologist',
            'Psychiatrist',
            'Social Worker'
        ];

        foreach ($designations as $key => $designation) {
            $designationData[] = [
                'title' => $designation,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => 1,
            ];
        }
        DB::table('designations')->insert($designationData);

        if ($input) {
            $lastDesignationId = DB::table('designations')->pluck('id')->last();
            $input['designation_id'] = $lastDesignationId;
            session()->put('input', $input);
        }
    }
}
