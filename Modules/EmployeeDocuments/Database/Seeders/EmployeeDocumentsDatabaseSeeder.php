<?php

namespace Modules\EmployeeDocuments\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class EmployeeDocumentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $employees = User::all();
        foreach ($employees as $employee) {
            $employee->documents()->create([
                'document_type' => 'passport',
                'document_number' => '123456789',
                'document_expiration' => '2023-12-31',
            ]);

            $employee->documents()->create([
                'document_type' => 'passport',
                'document_number' => '987654321',
                'document_expiration' => '2024-06-30',
            ]);
        }

    }
}
