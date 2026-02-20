<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AdminVerificationMail extends Mailable
{
    public $code;
    public $email;

    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Verify your email')
                    ->view('admin.create.email-sent');
    }
}
