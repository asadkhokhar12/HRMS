<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ModuleSeeder;
use Database\Seeders\UploadSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\Admin\StatusSeeder;
use Database\Seeders\Admin\CompanySeeder;
use Database\Seeders\CompanyConfigSeeder;
use Database\Seeders\Hrm\AllContentSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\SubscriptionSeeder;
use Database\Seeders\Hrm\Country\CountrySeeder;
use Modules\Saas\Database\Seeders\CmsTableSeeder;
use Modules\Saas\Database\Seeders\EmailTemplateSeeder;
use Database\Seeders\Traits\ApplicationKeyGenerate;
use Database\Seeders\Hrm\AppSetting\AppScreenSeeder;

class SaasSeeder extends Seeder
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

        $this->call(CountrySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(CompanyConfigSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(CmsTableSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(AppScreenSeeder::class);
        $this->call(AllContentSeeder::class);

        $this->call(ModuleSeeder::class);
    }
}
