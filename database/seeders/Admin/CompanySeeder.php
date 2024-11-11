<?php

namespace Database\Seeders\Admin;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::firstOrCreate([
            'name' => 'Admin',
            'company_name' => 'Main Company',
            'email' => 'demo@onesttech.com',
        ], [
            'phone' => '+8801959335555',
            'total_employee' => 100,
            'business_type' => 'Service',
            'is_main_company' => 'yes',
            'country_id' => 223,
        ]);
    }
}
