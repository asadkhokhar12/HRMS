<?php

namespace Database\Seeders\Hospital;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Helpers\CoreApp\Traits\PermissionTrait;

class UserSeeder extends Seeder
{
    use PermissionTrait;
    
    public function run()
    {
        try {
            $AdminUser = [
                'name' => "Admin",
                'email' => 'admin@onesttech.com',
                'is_admin' => 1,
                'is_hr' => 0,
                'role_id' => 2,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 1,
                'designation_id' => 1,
                'phone' => '0171xxxxxxxx',
                'permissions' => json_encode($this->adminPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($AdminUser);
            $HrUser = [
                'name' => "HR",
                'email' => 'hr@onesttech.com',
                'is_admin' => 0,
                'is_hr' => 1,
                'role_id' => 3,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 1,
                'designation_id' => 3,
                'phone' => '0172xxxxxxxx',
                'permissions' => json_encode($this->hrPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($HrUser);
            $doctorUser = [
                'name' => "Doctor",
                'email' => 'doctor@onesttech.com',
                'is_admin' => 0,
                'is_hr' => 0,
                'role_id' => 4,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 8,
                'designation_id' => 5,
                'phone' => '0173xxxxxxxx',
                'permissions' => json_encode($this->staffPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($doctorUser);



            $nurseUser = [
                'name' => "Nurse",
                'email' => 'nurse@onesttech.com',
                'is_admin' => 0,
                'is_hr' => 0,
                'role_id' => 4,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 8,
                'designation_id' => 6,
                'phone' => '0174xxxxxxxx',
                'permissions' => json_encode($this->staffPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($nurseUser);
            $pharmacistUser = [
                'name' => "Pharmacist",
                'email' => 'pharmacist@onesttech.com',
                'is_admin' => 0,
                'is_hr' => 0,
                'role_id' => 4,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 9,
                'designation_id' => 8,
                'phone' => '0175xxxxxxxx',
                'permissions' => json_encode($this->staffPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($pharmacistUser);




            $Radiologist = [
                'name' => "Radiologist",
                'email' => 'radiologist@onesttech.com',
                'is_admin' => 0,
                'is_hr' => 0,
                'role_id' => 4,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 17,
                'designation_id' => 9,
                'phone' => '0176xxxxxxxx',
                'permissions' => json_encode($this->staffPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($Radiologist);
        } catch (\Throwable $th) {
            Log::error($th);
            echo $th->getMessage();
        }


        // 10 users 
    }
}
