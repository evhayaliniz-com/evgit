<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $content;

    public function __construct($subjectText, $content)
    {
        $this->subjectText = $subjectText;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
            ->view('emails.dynamic-template')
            ->with(['content' => $this->content]);
    }
}
