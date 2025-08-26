<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusAlteradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $provisionalPassword;
    public $userEmail;

    public function __construct(string $provisionalPassword, string $userEmail)
    {
        $this->provisionalPassword = $provisionalPassword;
        $this->userEmail = $userEmail;
    }

    public function build()
    {
        return $this->subject("Sua Senha Provisória")
                    ->markdown('emails.status_alterado');
    }
}
