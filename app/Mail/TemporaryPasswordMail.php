<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TemporaryPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $temporaryPassword;
    public $userEmail;

    public function __construct(string $temporaryPassword, string $userEmail)
    {
        $this->temporaryPassword = $temporaryPassword;
        $this->userEmail = $userEmail;
    }

    public function build()
    {
        return $this->subject("Sua Senha Provisória")
                    ->markdown('emails.status_alterado');
    }
}
