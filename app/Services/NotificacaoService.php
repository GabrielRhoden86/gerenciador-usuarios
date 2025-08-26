<?php
namespace App\Services;

use App\Mail\StatusAlteradoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificacaoService
{
    public function notificarUsuarioSenhaProvisoria(string $userEmail, string $provisionalPassword): void
    {
        Mail::to($userEmail)
            ->send(new StatusAlteradoMail($provisionalPassword, $userEmail));
        Log::info("Senha provisória enviada para: " . $userEmail);
    }
}
