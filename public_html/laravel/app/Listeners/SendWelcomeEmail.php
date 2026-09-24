<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered; // ✅ Laravel'in kendi event'i
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmail
{
    /**
     * Prevents duplicate welcome emails for the same user within one request.
     *
     * @var array<int, bool>
     */
    protected static array $welcomedUsers = [];

    public function handle(Registered $event)
    {
        $user = $event->user;

        if (isset(self::$welcomedUsers[$user->id])) {
            return;
        }

        self::$welcomedUsers[$user->id] = true;

        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}
