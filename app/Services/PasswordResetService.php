<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Events\RequestPasswordReset;
use App\Repositories\UserRepository;
use App\Repositories\PasswordResetRepository;

class PasswordResetService
{
    protected $usuarios;
    protected $repository;

    public function __construct(UserRepository $usuarios, PasswordResetRepository $repository)
    {
        $this->usuarios = $usuarios;
        $this->repository = $repository;
    }
    public function sendLinkMail(string $email)
    {
        $usuario = $this->usuarios->findByEmail($email);
        if (!$usuario) {
            throw new \Exception('Usuário não encontrado');
        }
        $token = Str::random(60);
        $this->repository->storeToken($email, $token);
        event(new RequestPasswordReset($usuario, $token));
    }

    public function resetPassword($request){
        $this->repository->validateToken($request->email, $request->token);
        $result = $this->repository->saveNewPassword($request->email, $request->password);
        return $result;
    }
}
