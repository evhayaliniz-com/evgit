<?php

namespace App\Listeners;

use App\Mail\AdminNewUserNotification;
use App\Traits\AdminNotificationTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class SendAdminNotificationOnRegistration
{
    use AdminNotificationTrait;

    /**
     * Request-scope cache to avoid duplicate notifications for the same user.
     *
     * @var array<int, bool>
     */
    protected static array $notifiedUsers = [];

    public function handle(Registered $event)
    {
        $newUser = $event->user;

        if (isset(self::$notifiedUsers[$newUser->id])) {
            return;
        }

        self::$notifiedUsers[$newUser->id] = true;

        // Eager load company relationships for email template
        if ($newUser->user_type === 'company') {
            $newUser->load('company.category', 'company.subCategory');
        }

        $this->notifyAdmins(new AdminNewUserNotification($newUser));

        $typeLabel = $newUser->user_type === 'company' ? 'firma' : 'kullanıcı';
        $name = $newUser->user_type === 'company'
            ? optional($newUser->company)->name
            : optional($newUser->informations)->name;

        $displayName = $name ?: $newUser->email;

        $link = $newUser->user_type === 'company'
            ? route('admin.companies.index')
            : route('admin.users.index');

        $message = sprintf('Yeni %s kaydı: %s', Str::title($typeLabel), $displayName);

        $this->createAdminNotifications($message, $link, $newUser->id);
    }
}
