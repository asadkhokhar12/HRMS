<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendExpireNotificationEmailQueue extends Mailable
{
    use Queueable, SerializesModels;
    protected $userData;

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Send Expire Notification Email',
            
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.expire_notification_mail',
            with: ['user' => $this->userData]
        );
    }

    public function attachments()
    {
        return [];
    }
}
