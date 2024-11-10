<?php

namespace Database\Seeders\Admin;

use App\Models\Subscription;
use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = session()->get('input');
        // Check if session input data is available
        if (@$input['invoice_no']) {
            try {
                // Create a subscription using session input data
                Subscription::create([
                    'subscription_id_in_main_company' => $input['subscription_id_in_main_company'],
                    'invoice_no'        => $input['invoice_no'],
                    'plan_name'         => $input['plan_name'],
                    'price'             => $input['price'],
                    'payment_gateway'   => $input['payment_gateway'],
                    'trx_id'            => $input['trx_id'],
                    'employee_limit'    => $input['employee_limit'],
                    'is_employee_limit' => $input['is_employee_limit'],
                    'expiry_date'       => $input['expiry_date'],
                    'features'          => $input['features'],
                    'features_key'      => $input['features_key'],
                    'is_demo_checkout'  => $input['is_demo_checkout'],
                    'offline_payment'   => $input['offline_payment'],
                    'source'            => @$input['subscription_source'] ?? 'Website',
                    'payment_status_id' => $input['payment_status_id'],
                ]);

                // Log::alert(session()->get('input'));
            } catch (\Throwable $th) {
                Log::error('Subscription Seeder Failed');
                echo $th->getMessage();
            }
        }
    }
}
