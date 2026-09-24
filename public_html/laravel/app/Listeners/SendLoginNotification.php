<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login; // ✅ DOĞRU NAMESPACE
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotificationMail;

class SendLoginNotification
{
    public function handle(Login $event) // ✅ BURADA Illuminate\Auth\Events\Login
    {
        $user = $event->user;

        Mail::to($user->email)->send(new LoginNotificationMail($user));
    }
}
