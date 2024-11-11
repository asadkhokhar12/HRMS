<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendDocumentRequestQueue extends Mailable
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
            subject: 'Send Document Request Email',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.document_request_mail',
            with: ['user' => $this->userData]
        );
    }

    public function attachments()
    {
        return [];
    }
}
