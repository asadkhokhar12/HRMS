<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $user_id = $input['user_id'] ?? 1;

        $newBranch = Branch::create([
            'name' => 'Head Office',
            'address' => $input['address'] ?? "Texas, USA",
            'phone' => $input['phone'] ?? '01234567890',
            'email' => $input['email'] ?? "admin@gmail.com",
            'user_id' => $user_id,
            'company_id' => $company_id,
        ]);
        if ($input) {
            $input['branch_id'] = $newBranch;
            session()->put('input', $input);
        }
    }
}
