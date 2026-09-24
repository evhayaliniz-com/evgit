<?php

namespace App\Mail;

use App\Models\Service;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewServiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Service $service;
    public User $creator;

    public function __construct(Service $service, User $creator)
    {
        $this->service = $service;
        $this->creator = $creator;
    }

    public function build()
    {
        return $this->subject('Yeni Hizmet Eklendi - Onay Sürecinde')
            ->view('emails.admin-service-created');
    }
}
