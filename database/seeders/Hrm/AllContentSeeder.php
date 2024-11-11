<?php

namespace Database\Seeders\Hrm;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $path = 'database/seeders/sqls/all_contents.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

    
        DB::table('all_contents')->insert([
            'company_id' => 1,
            'user_id' => 1,
            'type' => 'Company Policies',
            'title' => 'Company Policies',
            'slug' => 'company-policies',
            'content' => '
            <h1>Company Policies</h1>

            <h2>1. Code of Conduct and Ethics Policy</h2>
            <p>Our company is committed to maintaining the highest ethical standards in all aspects of our business operations...</p>

            <h2>2. Equal Employment Opportunity (EEO) Policy</h2>
            <p>Our company provides equal employment opportunities to all employees and applicants without regard to...</p>

            ',
            'meta_title' => 'Company Policies',
            'meta_description' => 'Company Policies',
            'keywords' => 'company-policies',
            'meta_image' => 'sample.jpg',
            'created_by' => 1,
            'updated_by' => 1,
            'status_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
