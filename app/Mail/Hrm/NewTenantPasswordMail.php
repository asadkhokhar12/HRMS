<?php

namespace App\Mail\Hrm;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class NewTenantPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $password,$company;

    public function __construct($company, $password)
    {
        $this->company = $company;
        $this->password = $password;
    }
    
    public function build()
    {

        $company = $this->company; // Get the company object from the constructor
        $password = $this->password;
        return $this->view('emails.new_tenant_mail', compact('password', 'company'))->subject('Login Credentials');
    }
}
