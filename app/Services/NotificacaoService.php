<?php

namespace App\Services;

use App\Mail\StatusAlteradoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificacaoService
{
    public function notificarGestorAlteracaoStatus(array $dadosNotificacao): void
    {
        $nomeAluno      = $dadosNotificacao['nomeAluno'];
        $alunoId        = $dadosNotificacao['alunoId'];
        $statusAnterior = $dadosNotificacao['statusAnterior'];
        $statusNovo     = $dadosNotificacao['statusNovo'];
        $emailDestino   = $dadosNotificacao['emailUsuario']; 

        Mail::to($emailDestino)
            ->send(new StatusAlteradoMail($nomeAluno, $alunoId, $statusAnterior, $statusNovo));
        Log::info("Notificação para gestor: Aluno [ID {$alunoId} - {$nomeAluno}] teve o status alterado de '{$statusAnterior}' para '{$statusNovo}'.");
    }
}
