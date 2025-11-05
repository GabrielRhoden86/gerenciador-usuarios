<?php

namespace App\Services;
use Throwable;
use Illuminate\Support\Str;
use App\Events\RequestPasswordReset;
use App\Repositories\UserRepository;
use App\Repositories\PasswordResetRepository;

class PasswordResetService
{
    protected $usuarios;
    protected $passwordResets;

    public function __construct(UserRepository $usuarios, PasswordResetRepository $passwordResets)
    {
        $this->usuarios = $usuarios;
        $this->passwordResets = $passwordResets;
    }

    public function sendLinkMail(string $email)
    {
        $usuario = $this->usuarios->findByEmail($email);
        if (!$usuario) {
            throw new \Exception('Usuário não encontrado');
        }
        $token = Str::random(60);
        $this->passwordResets->storeToken($email, $token);
        event(new RequestPasswordReset($usuario, $token));
    }
}
