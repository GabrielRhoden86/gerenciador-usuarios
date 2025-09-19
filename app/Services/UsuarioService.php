<?php

namespace App\Services;
use Throwable;
use App\Enums\PerfilUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\UsuarioRepository;
use App\Services\NotificacaoService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\User;

class UsuarioService
{
    protected UsuarioRepository $usuarioRepository;
    protected NotificacaoService $notificacaoService;
    public function __construct(UsuarioRepository $usuarioRepository, NotificacaoService $notificacaoService) {
        $this->usuarioRepository = $usuarioRepository;
        $this->notificacaoService = $notificacaoService;
    }
    public function cadastrarUsuario(array $dados)
    {
        if (Gate::denies('create', Auth::user())) {
             throw new \Exception('Somente Administradores podem cadastrar usuários',
              403);
        }

        if (empty($dados['password'])) {
            $provisionalPassword = Str::random(8);
            $this->notificacaoService->notificarUsuarioSenhaProvisoria($dados['email'], $provisionalPassword);
            $dados['password'] = $provisionalPassword;
        }

            $dados['password'] = Hash::make($dados['password']);
            $usuario = $this->usuarioRepository->create($dados);

            return $usuario;
    }
    public function editarUsuario(array $dados, int $id)
    {
        $usuario = User::findOrFail($id);

        if (Gate::denies('update', $usuario)) {
            throw new \Exception('Somente Administradores podem alterar perfis de outros usuários.', 403);
        }

        if (!empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        }

        return $this->usuarioRepository->update($dados, $id);
    }

    public function listarUsuarios(array $filtros = [], int $perPage = 10)
    {
        $usuarios =  $this->usuarioRepository->findAll($filtros, $perPage);
          return [
           'data'    => $usuarios['paginacao'],
           'todos'   => $usuarios['todos'],
        ];
    }
    public function excluirUsuario($request, int $id)
    {
        $usuario = User::findOrFail($id);

        if (Gate::denies('delete', $usuario)) {
            throw new \Exception(
                'Somente Administradores podem excluir perfis de outros usuários.',
                403
            );
        }

        return $this->usuarioRepository->delete($id);
    }
    public function buscarUsuario(int $id)
    {
        $usuario = $this->usuarioRepository->findById($id);

        if (!$usuario) {
            throw new \Exception('Usuário não encontrado', 404);
        }

        return $usuario;
    }
}
