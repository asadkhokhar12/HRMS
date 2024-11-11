<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
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

        if (env('APP_INSTITUTION') === "hospital") {
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
        } else if (env('APP_INSTITUTION') === "bank") {
            $designations = [
                'Chairman',
                'Managing Director',
                'HR Manager',
                'IT Manager',
                'Bank Teller',
                'Branch Manager',
                'Loan Officer',
                'Financial Analyst',
                'Customer Service Representative',
                'Operations Manager',
                'Risk Analyst',
                'Investment Banker',
                'Credit Analyst',
                'Auditor',
                'Financial Advisor',
                'Accountant',
                'Treasury Analyst',
                'Mortgage Consultant',
                'Fraud Investigator',
            ];
        } else {
            if(env('APP_COMPANY') == "imprint"){
                $designations = [
                    'MD',
                    'CEO',
                    'CIO',
                    'HR Manager',
                    'IT Manager',
                    'Marketing Manager',
                    'Sales Manager',
                    'Accounts Manager',
                    'Finance Manager',
                    'Team Lead',
                    'Customer Service Executive (CSR)',
                    'Production Approval Analyst',
                    'Designer',
                    'Project Manager',
                    'Web Developer',
                    'Sr. Web Developer',
                    'Mobile Application Developer',
                    'UI UX Designer',
                    'Software Quality Assurance (SQA)',
                    'Inventory Control Executive',
                    'Business Operation Officer',
                    'Social Communication Executive',
                    'Marketing Executive',
                    'Production Manager',
                    'Digital Marketing Executive',
                    'Vendor Executive',
                    'Business Analyst',
                    'Content Writer',
                    'PR & Media Branding Manager'
                ];
            } else{
                $designations = ['Admin', 'HR', 'Staff'];
            }
        }


        // Arrays to store data for bulk insert
        $designationData = [];
        $departmentData = [];

        foreach ($designations as $key => $designation) {
            // Prepare data for designations
            $designationData[] = [
                'title' => $designation,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => 1,
            ];
        }
        // Bulk insert data into 'designations' and 'departments' tables
        DB::table('designations')->insert($designationData);

        if ($input) {

            // Update input with the last inserted IDs for designations
            $lastDesignationId = DB::table('designations')->pluck('id')->last();

            $input['designation_id'] = $lastDesignationId;

            session()->put('input', $input);
        }
    }
}
