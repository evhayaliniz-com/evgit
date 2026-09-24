<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $sender;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->sender = User::find($message->sender_id);
    }

    public function build()
    {
        return $this->markdown('emails.new-message')
                    ->subject('Yeni Mesajınız Var');
    }
}
