<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusAlteradoMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $alunoId;
    public string $nomeAluno;
    public string $statusAnterior;
    public string $statusNovo;

    public function __construct(string $nomeAluno, int $alunoId, string $statusAnterior, string $statusNovo)
    {
        $this->nomeAluno = $nomeAluno;
        $this->alunoId = $alunoId;
        $this->statusAnterior = $statusAnterior;
        $this->statusNovo = $statusNovo;
    }

    public function build()
    {
        return $this->subject("Status do Aluno #{$this->alunoId} Alterado")
                    ->markdown('emails.status_alterado');
    }
}
