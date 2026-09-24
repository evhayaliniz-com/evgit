<?php

namespace App\Mail;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewIdeaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Idea $idea;
    public User $creator;

    public function __construct(Idea $idea, User $creator)
    {
        $this->idea = $idea;
        $this->creator = $creator;
    }

    public function build()
    {
        return $this->subject('Yeni Fikir Eklendi - Onay Sürecinde')
            ->view('emails.admin-idea-created');
    }
}
