<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Saas\Database\Seeders\SaasDatabaseSeeder;
use Modules\MenuPermission\Database\Seeders\MenuPermissionDatabaseSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        if (isModuleActive("MenuPermission")) {
            $this->call(MenuPermissionDatabaseSeeder::class);
        }
    }
}
