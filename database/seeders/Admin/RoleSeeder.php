<?php

namespace Database\Seeders\Admin;

use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Models\Company\Company;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    use PermissionTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'superadmin',
            'admin',
            'hr',
            'staff',
        ];

        if (empty(session()->get('input'))) {
            $companies = Company::all();
            foreach ($companies as $key => $company) {
                foreach ($roles as $key => $role) {
                    Role::updateOrCreate([
                        'name' => $role,
                        'slug' => $role,
                        'company_id' => $company->id,
                        'branch_id' => 1,
                    ], [
                        'permissions' => json_encode($this->customPermissions($role)),
                        'status_id' => 1,
                        'app_login' => 1,
                        'web_login' => 1,
                    ]);
                }
            }
        } else {
            $input = session()->get('input');
            $company_id = $input['company_id'] ?? 1;
            $user_id = $input['user_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;
            foreach ($roles as $key => $role) {
                Role::updateOrCreate([
                    'name' => $role,
                    'slug' => $role,
                    'company_id' => $company_id,
                    'branch_id' => $branch_id,
                ], [
                    'permissions' => json_encode($this->customPermissions($role)),
                    'status_id' => 1,
                    'app_login' => 1,
                    'web_login' => 1,
                ]);
            }
        }

    }
}
