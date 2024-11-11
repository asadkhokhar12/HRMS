<?php

namespace Database\Seeders\Management;

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // client

        $client = [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'phone' => '123456789',
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'country' => 'USA',
            'website' => 'www.john.com',
            'status_id' => 1,
            'company_id' => 2,
        ];
        \App\Models\Management\Client::create($client);

    }
}
