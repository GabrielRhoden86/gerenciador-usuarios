<?php

namespace App\Listeners;

use App\Events\SolicitarResetSenha;
use Illuminate\Support\Facades\Mail;

class EnviarEmailResetSenha
{
    /**
     * Handle the event.
     */
    public function handle(SolicitarResetSenha $event): void
    {
        $usuario = $event->usuario;
        $token = $event->token;

        $resetUrl = url("/reset-password/{$token}?email={$usuario->email}");

        Mail::raw(
            "Olá {$usuario->name}, clique no link abaixo para resetar sua senha:\n\n{$resetUrl}",
            function ($message) use ($usuario) {
                $message->to($usuario->email)
                        ->subject('Redefinição de senha');
            }
        );
    }
}
