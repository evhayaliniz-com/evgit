<?php


namespace App\Traits;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicTemplateMail;

trait EmailTemplateTrait
{
    public function triggerEmailTemplate($key, $user, array $data = [])
    {
        $template = EmailTemplate::where('key', $key)
            ->where('status', 1)
           // ->whereJsonContains('roles', $user->user_type)
            ->first();

        if (!$template) return false;

        $subject = $template->subject;
        $content = $template->content;

        foreach ($data as $k => $v) {
            $subject = str_replace('{{' . $k . '}}', $v, $subject);
            $content = str_replace('{{' . $k . '}}', $v, $content);
        }

        Mail::to($user->email)->send(new DynamicTemplateMail($subject, $content));

        return true;
    }
}
