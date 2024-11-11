<?php

namespace Database\Seeders\Admin;

use App\Models\coreApp\Status\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [

                // 1
                'name' => 'Active',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 2
                'name' => 'Pending',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 3
                'name' => 'Suspended',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 4
                'name' => 'Inactive',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 5
                'name' => 'Approve',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 6
                'name' => 'Reject',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 7
                'name' => 'Cancel',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 8
                'name' => 'Paid',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 9
                'name' => 'Unpaid',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 10
                'name' => 'Claimed',
                'class' => 'primary',
                'color_code' => '337ab7',
            ],
            [
                // 11
                'name' => 'Not Claimed',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 12
                'name' => 'Open',
                'class' => 'danger',
                'color_code' => 'ffFD815B',
            ],
            [
                // 13
                'name' => 'Close',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 14
                'name' => 'High',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 15
                'name' => 'Medium',
                'class' => 'primary',
                'color_code' => '337ab7',
            ],
            [
                // 16
                'name' => 'Low',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 17
                'name' => 'Referred',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 18
                'name' => 'Debit',
                'class' => 'danger',
                'color_code' => 'ffFD815B',
            ],
            [
                // 19
                'name' => 'Credit',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 20
                'name' => 'Partially Paid',
                'class' => 'info',
                'color_code' => '9DBBCE',
            ],
            [
                // 21
                'name' => 'Partially Returned',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 22
                'name' => 'No',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 23
                'name' => 'Returned',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 24
                'name' => 'Not Started',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 25
                'name' => 'On Hold',
                'class' => 'info',
                'color_code' => '9DBBCE',
            ],
            [
                // 26
                'name' => 'In Progress',
                'class' => 'main',
                'color_code' => '7F58FE',
            ],
            [
                // 27
                'name' => 'Completed',
                'class' => 'success',
                'color_code' => '449d44',
            ],
            [
                // 27
                'name' => 'Cancelled',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],

            // priority
            [
                // 28
                'name' => 'Urgent',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 29
                'name' => 'High',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 30
                'name' => 'Medium',
                'class' => 'primary',
                'color_code' => '337ab7',
            ],
            [
                // 31
                'name' => 'Low',
                'class' => 'warning',
                'color_code' => 'ec971f',
            ],
            [
                // 32
                'name' => 'Yes',
                'class' => 'primary',
                'color_code' => '337ab7',
            ],
            [
                // 33
                'name' => 'Terminated',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],
            [
                // 34
                'name' => 'Resign',
                'class' => 'danger',
                'color_code' => 'c9302c',
            ],

        ];

        try {
            Status::query()->insert($statuses);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
