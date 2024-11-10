<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExpireNotificationCommand extends Command
{
    protected $signature = 'notification:expire';
    protected $description = 'Expire notification';

    public function handle()
    {
        $url = route('send-expire-notification');
        $response = Http::withoutVerifying()->get($url);

        if ($response->successful()) {
            $this->info('Request was successful. Response: ' . $response->body());
        } else {
            $this->error('Request failed. Status Code: ' . $response->status());
        }
    }
}
