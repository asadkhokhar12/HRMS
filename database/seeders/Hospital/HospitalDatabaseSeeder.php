<?php

namespace Database\Seeders\Hospital;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Database\Seeders\LeaveTypeSeeder;
use Database\Seeders\Hospital\UserSeeder;
use Database\Seeders\Hrm\LeaveSettingSeeder;
use Database\Seeders\Hospital\DepartmentSeeder;
use Database\Seeders\Hospital\PermissionSeeder;
use Database\Seeders\Hospital\AssignLeaveSeeder;
use Database\Seeders\Hospital\DesignationSeeder;
use Database\Seeders\Hospital\LeaveRequestSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HospitalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DesignationSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LeaveSettingSeeder::class);

        $this->call(LeaveTypeSeeder::class);
        $this->call(AssignLeaveSeeder::class);
        $this->call(LeaveRequestSeeder::class);
    }
}
