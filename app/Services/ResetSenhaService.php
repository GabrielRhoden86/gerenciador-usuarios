<?php

namespace App\Services;
use Throwable;
use Illuminate\Support\Str;
use App\Events\SolicitarResetSenha;
use App\Repositories\UsuarioRepository;
use App\Repositories\PasswordResetRepository;

class ResetSenhaService
{
    protected $usuarios;
    protected $passwordResets;

    public function __construct(UsuarioRepository $usuarios, PasswordResetRepository $passwordResets)
    {
        $this->usuarios = $usuarios;
        $this->passwordResets = $passwordResets;
    }

    public function enviarLink(string $email)
    {
        $usuario = $this->usuarios->findByEmail($email);
        if (!$usuario) {
            throw new \Exception('Usuário não encontrado');
        }
        $token = Str::random(60);
        $this->passwordResets->storeToken($email, $token);
        event(new SolicitarResetSenha($usuario, $token));
    }
}
