<?php

namespace App\Listeners;

use App\Events\RequestPasswordReset;
use App\Mail\PasswordResetMail; // <--- Importe a nova classe
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail implements ShouldQueue
{
    // para executar a fila de envio do email: php artisan queue:work
    // ou envia de forma sincrona retire isso ShouldQueue e nao havera fila de espera
    // em produção usar o supervisor(daemon)
    public function handle(RequestPasswordReset $event): void
    {
        $user = $event->user;
        $token = $event->token;

        $resetUrl = url("/reset-password/{$token}?email={$user->email}");
        Mail::to($user->email)->send(
            new PasswordResetMail($user, $resetUrl)
        );
    }
}
