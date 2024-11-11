<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDocumentRequestSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Define the possible request types
        $requestTypes = ['NOC', 'Salary Certificate', 'Others'];

        DB::table('user_document_requests')->insert([
            'status_id' => 1,
            'user_id' => 1,
            'branch_id' => 1,
            'company_id' => 1,
            'request_type' => $requestTypes[rand(0, 2)],
            'request_description' => 'Sample request description ' . 1,
            'approved' => rand(0, 1),
            'request_date' => now()->subDays(rand(25, 30)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
