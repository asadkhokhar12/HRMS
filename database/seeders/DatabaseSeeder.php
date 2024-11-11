<?php

use Illuminate\Database\Seeder;
use Database\Seeders\SaasSeeder;
use Database\Seeders\RegularSeeder;
use Database\Seeders\Traits\ApplicationKeyGenerate;

class DatabaseSeeder extends Seeder
{
    // use ApplicationKeyGenerate;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (isModuleActive('Saas') && config('app.mood') == 'Saas' && session()->get('input') == '') {
            $this->call(SaasSeeder::class);
        } else {
            $this->call(RegularSeeder::class);
        }
    }
}
