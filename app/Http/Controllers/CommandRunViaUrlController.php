<?php

namespace App\Http\Controllers;

use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\UserSeeder;
use Illuminate\Support\Facades\Artisan;

class CommandRunViaUrlController extends Controller
{
    public function runPermissionSeederViaURL()
    {
        ini_set('max_execution_time', 300);

        try {
            Artisan::call('db:seed', ['--class' => PermissionSeeder::class]);
            return _trans('response.success');
        } catch (\Throwable $th) {
            return _trans('response.failed');
        }
    }

    public function runRoleSeederViaURL()
    {
        ini_set('max_execution_time', 300);

        try {
            Artisan::call('db:seed', ['--class' => RoleSeeder::class]);
            return _trans('response.success');
        } catch (\Throwable $th) {
            return _trans('response.failed');
        }
    }

    public function runUserSeederViaURL()
    {
        ini_set('max_execution_time', 300);

        try {
            Artisan::call('db:seed', ['--class' => UserSeeder::class]);
            return _trans('response.success');
        } catch (\Throwable $th) {
            return _trans('response.failed');
        }
    }
}
