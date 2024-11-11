<?php

namespace Database\Seeders;

use App\Models\Company\Company;
use App\Models\Settings\HrmLanguage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Hrm\Leave\LeaveSetting;
use App\Models\coreApp\Setting\CompanyConfig;

class CompanyConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config_data = [
            "date_format" => "d-m-Y",
            "time_format" => "h",
            "ip_check" => "0",
            "leave_assign" => "0",
            "currency_symbol" => "$",
            "location_service" => "0",
            "app_sync_time" => "",
            "live_data_store_time" => "",
            "lang" => "en",
            "multi_checkin" => 0,
            "currency" => 2,
            "timezone" => "Asia/Dhaka",
            "currency_code" => "USD",
            'location_check' => 0,
            'attendance_method' => 'N',
            'google'=>'AIzaSyBVF8ZCdPLYBEC2-PCRww1_Q0Abe5GYP1c',
            'is_employee_passport_required' => 0,
            'is_employee_eid_required' => 0,
            'min_phone_no_digit' => 11,
            'max_phone_no_digit' => 11,
            'leave_carryover' => 0,
        ];
        if ($input = session()->get('input')) {
            $company_id = $input['company_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;
        } else {
            $company_id = 1;
            $branch_id = 1;
        }
        CompanyConfig::truncate();
        foreach ($config_data as $key => $value) {
            $company_config = new CompanyConfig;
            $company_config->key = $key;
            $company_config->value = $value;
            $company_config->company_id = $company_id;
            $company_config->branch_id = $branch_id;
            $company_config->save();
        }

    
        $apis = [
            'google', 'barikoi'
        ];
        foreach ($apis as $key => $api) {
            DB::table('api_setups')->insert([
                'name' => $api,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => $key == 0 ? 1 : 4,
            ]);
        }

        HrmLanguage::create([
            'language_id' => 19,
            'is_default' => 1,
            'status_id' => 1,
        ]);
    }
}
