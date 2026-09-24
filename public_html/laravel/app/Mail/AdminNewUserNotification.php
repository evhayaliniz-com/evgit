<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminNewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $newUser;
    public $userName;
    public $userType;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $newUser
     * @return void
     */
    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;

        // Kullanıcı tipine göre isim al
        if ($newUser->user_type === 'company') {
            $this->userName = optional($newUser->company)->name ?? 'Bilinmiyor';
            $this->userType = 'Firma';
        } elseif ($newUser->user_type === 'user') {
            $this->userName = optional($newUser->informations)->name ?? 'Bilinmiyor';
            $this->userType = 'Bireysel Kullanıcı';
        } else {
            $this->userName = $newUser->name ?? 'Bilinmiyor';
            $this->userType = ucfirst($newUser->user_type ?? 'Kullanıcı');
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subjectPrefix = $this->newUser->user_type === 'company'
            ? 'Yeni Firma Kayıt'
            : 'Bireysel Üye Kayıt';

        return $this->subject($subjectPrefix . ' - ' . $this->userName)
            ->view('emails.admin-new-user');
    }
}
