<?php
namespace App\Services;

use App\Mail\TemporaryPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function notifyUserTemporaryPassword(string $userEmail, string $provisionalPassword): void
    {
        Mail::to($userEmail)
            ->send(new TemporaryPasswordMail($provisionalPassword, $userEmail));
        Log::info("Senha provisória enviada para: " . $userEmail);
    }
}
