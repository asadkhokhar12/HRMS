<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\UploadSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\Admin\StatusSeeder;
use Database\Seeders\DutyScheduleSeeder;
use Database\Seeders\WeekendSetupSeeder;
use Database\Seeders\Admin\CompanySeeder;
use Database\Seeders\CompanyConfigSeeder;
use Database\Seeders\Hrm\Shift\ShiftSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\AllContentsTableSeeder;
use Database\Seeders\Admin\SubscriptionSeeder;
use Database\Seeders\Hrm\Country\CountrySeeder;
use Database\Seeders\Traits\ApplicationKeyGenerate;
use Database\Seeders\Hrm\AppSetting\AppScreenSeeder;
use Database\Seeders\Hospital\HospitalDatabaseSeeder;

class RegularSeeder extends Seeder
{
    use ApplicationKeyGenerate;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // $this->keyGenerate();
        // ---------------------------------- global --------------------------------
        $this->call(CountrySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        // ------------------------------- institute based --------------------------------
        if (env('APP_INSTITUTION') === "hospital") {
            $this->call(HospitalDatabaseSeeder::class);
        } else {
            $this->call(DepartmentSeeder::class);
            $this->call(DesignationSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(LeaveTypeSeeder::class);
        }

        $this->call(SettingsSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(CompanyConfigSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(DutyScheduleSeeder::class);
        $this->call(WeekendSetupSeeder::class);
        $this->call(AllContentsTableSeeder::class);
        $this->call(AppScreenSeeder::class);
    }
}
