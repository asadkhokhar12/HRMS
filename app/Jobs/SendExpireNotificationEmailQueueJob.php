<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendExpireNotificationEmailQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Mail;

class SendExpireNotificationEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send_mail;
    protected $userData;

    public function __construct($send_mail, $userData)
    {
        $this->send_mail = $send_mail;
        $this->userData = $userData;
    }

    public function handle()
    {
        $email = new SendExpireNotificationEmailQueue($this->userData);
        Mail::to($this->send_mail)->send($email);
    }
}
