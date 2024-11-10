<?php

namespace Database\Seeders\Hrm;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use App\Models\Hrm\Attendance\Holiday;
use Faker\Factory as Faker;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $holidays = [
            [
                'date' => '2023-01-01',
                'name' => 'New Year',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-03-17',
                'name' => 'Sheikh Mujib\'s Birthday',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-03-26',
                'name' => 'Independence Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-04-14',
                'name' => 'Bengali New Year',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-04-21',
                'name' => 'Good Friday',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-05-01',
                'name' => 'May Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-05-07',
                'name' => 'Buddha Purnima',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-05-17',
                'name' => 'Jumatul Bidah',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-05-21',
                'name' => 'Eid ul-Fitr',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-06-07',
                'name' => 'National Mourning Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-08-15',
                'name' => 'National Mourning Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-10-02',
                'name' => 'Durga Puja',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-10-19',
                'name' => 'Eid ul-Adha',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-11-10',
                'name' => 'Muharram',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-12-16',
                'name' => 'Victory Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
            [
                'date' => '2023-12-25',
                'name' => 'Christmas Day',
                'type' => 'Public Holiday',
                'description' => ''
            ],
        ];


        if ($input = session()->get('input')) {
            $company_id = $input['company_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;

            session()->put('input', $input);
        } else {
            $company_id = 1;
            $branch_id = 1;
        }

        foreach ($holidays as $holidayData) {
            $holiday = new Holiday();
            $holiday->company_id = $company_id;
            $holiday->branch_id = $branch_id;
            $holiday->title = $holidayData['name'];
            $holiday->type = $holidayData['type'];
            $holiday->description = $holidayData['description'];
            $holiday->start_date = $holidayData['date'];
            $holiday->end_date = $holidayData['date'];
            $holiday->status_id = 1;
            $holiday->save();
        }        
    }
}
