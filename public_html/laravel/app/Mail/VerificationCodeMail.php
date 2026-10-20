<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;

    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
    }

    public function build()
    {
        $siteName = config('app.name', 'Ev Hayaliniz');
        return $this->subject("E-posta Doğrulama Kodunuz – {$siteName}")
            ->view('emails.verification-code');
    }
}
