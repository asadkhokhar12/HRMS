<?php

namespace App\Mail\Hrm;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class AutoGeneratePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }
    
    public function build()
    {

        $password =  $this->password; // Assign the user object (plain password) to a separate variable
        return $this->view('emails.auto_generate_password', compact('password'))->subject('Default Password');
    }
}
