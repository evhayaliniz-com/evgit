<?php

namespace App\Traits;

use App\Models\AdminEmail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

trait AdminNotificationTrait
{
    /**
     * Retrieve admin users that have an email address defined.
     */
    protected function getAdminUsers(): Collection
    {
        return User::where('user_type', 'admin')
            ->whereNotNull('email')
            ->get();
    }

    /**
     * Retrieve all email addresses from the admin_emails table.
     */
    protected function getAdminEmails(): Collection
    {
        return AdminEmail::all();
    }

    /**
     * Send the given mailable to all email addresses in emails table.
     */
    protected function notifyAdmins(Mailable $mailable): void
    {
        $emailRecords = $this->getAdminEmails();

        if ($emailRecords->isEmpty()) {
            return;
        }

        $emails = $emailRecords->pluck('email')
            ->map(function ($email) {
                $normalized = trim($email);

                if ($normalized === '') {
                    return null;
                }

                if (function_exists('mb_strtolower')) {
                    $normalized = mb_strtolower($normalized);
                } else {
                    $normalized = strtolower($normalized);
                }

                return $normalized;
            })
            ->filter()
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            return;
        }

        Mail::to($emails->all())->send($mailable);
    }

    /**
     * Create Notification entries for all admins.
     */
    protected function createAdminNotifications(string $message, ?string $link = null, ?int $actorId = null): void
    {
        $admins = $this->getAdminUsers();

        if ($admins->isEmpty()) {
            return;
        }

        $actorId = $actorId ?? optional(auth()->user())->id ?? 0;

        $now = now();

        $records = $admins->map(function (User $admin) use ($message, $link, $actorId, $now) {
            return [
                'user_id' => $actorId,
                'to_id' => $admin->id,
                'message' => $message,
                'link' => $link,
                'is_read' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        });

        Notification::insert($records->all());
    }
}
