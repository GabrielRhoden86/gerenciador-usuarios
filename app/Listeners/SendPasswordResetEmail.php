<?php

namespace App\Listeners;

use App\Events\RequestPasswordReset;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail
{
    public function handle(RequestPasswordReset $event): void
    {
        $user = $event->user;
        $token = $event->token;
        $resetUrl = url("/reset-password/{$token}?email={$user->email}");

        Mail::raw(
            "Olá {$user->name}, clique no link abaixo para resetar sua senha:\n\n{$resetUrl}",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Redefinição de senha');
            }
        );
    }
}
