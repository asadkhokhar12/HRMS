<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Helpers\CoreApp\Traits\PermissionTrait;
use App\Models\UserShiftAssign;

class UserSeeder extends Seeder
{

    use PermissionTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            foreach($this->userData() ?? [] as $key => $user) {
                User::updateOrCreate([
                    'email'                     => $user['email'],
                ], [
                    'name'                      => $user['name'],
                    'is_admin'                  => @$user['is_admin'],
                    'is_hr'                     => @$user['is_hr'],
                    'role_id'                   => @$user['role_id'],
                    'company_id'                => @$user['company_id'],
                    'country_id'                => @$user['country_id'],
                    'department_id'             => @$user['department_id'],
                    'designation_id'            => @$user['designation_id'],
                    'phone'                     => @$user['phone'],
                    'permissions'               => @$user['permissions'],
                    'email_verified_at'          => now(),
                    'remember_token'            => Str::random(10),
                    'is_email_verified'          => 'verified',
                    'email_verify_token'        => Str::random(10),
                    'password'                  => Hash::make('12345678'),
                ]);

                UserShiftAssign::create([
                    'user_id' => $key+1,
                    'shift_id' => @$user['shift_id'],
                ]);
                
            }
        } catch (\Throwable $th) {
            // echo $th->getMessage();
        }
    }

    protected function userData()
    {
        return [
            [
                'name'                  => "Admin",
                'email'                 => 'admin@cybertronlabs.com',
                'is_admin'              => 1,
                'is_hr'                 => 0,
                'role_id'               => 2,
                'company_id'            => 1,
                'country_id'            => 223,
                'shift_id'              => 1,
                'department_id'         => 1,
                'designation_id'        => 1,
                'phone'                 => '0172xxxxxxxx',
                'permissions'           => json_encode($this->adminPermissions()),
            ],
            [
                'name'                      => "HR",
                'email'                     => 'hr@cybertronlabs.com',
                'is_admin'                  => 0,
                'is_hr'                     => 1,
                'role_id'                   => 3,
                'company_id'                => 1,
                'country_id'                => 223,
                'shift_id'                  => 1,
                'department_id'             => 1,
                'designation_id'            => 1,
                'phone'                     => '0171xxxxxxx1',
                'permissions'               => json_encode($this->hrPermissions()),
            ],
            [
                'name'                  => 'Staff',
                'email'                 => 'staff@cybertronlabs.com',
                'is_admin'              => 0,
                'is_hr'                 => 1,
                'role_id'               => 4,
                'company_id'            => 1,
                'country_id'            => 223,
                'shift_id'              => 1,
                'department_id'         => 1,
                'designation_id'        => 1,
                'phone'                 => '0171xxxxxx2',
                'permissions'           => json_encode($this->staffPermissions()),
            ]
        ];
    }
}
