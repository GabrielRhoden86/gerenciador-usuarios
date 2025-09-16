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
        try {
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

            return [
                'message' => 'Cadastro realizado com sucesso!',
                'data'   => $usuario
            ];
        } catch (Throwable $e) {
            Log::error("Erro ao cadastrar usuário: " . $e->getMessage());
            throw $e;
        }
    }
    public function editarUsuario(array $dados, int $id)
    {
        try {
            $usuarioEditado = User::findOrFail($id);

            if (Gate::denies('update', $usuarioEditado)) {
                throw new \Exception('Somente Administradores podem alterar perfis de outros usuários.',
                403);
            }

            if (isset($dados['password']) && !empty($dados['password'])) {
                $dados['password'] = Hash::make($dados['password']);
            }

            $usuarioAtualizado = $this->usuarioRepository->update($dados, $id);
            return [
                'message' => 'Dados atualizados com sucesso!',
                'data'   => $usuarioAtualizado
            ];

        } catch (Throwable $e) {
            Log::error("Erro ao atualizar usuário" . $e->getMessage());
            throw $e;
        }
    }
    public function listarUsuarios(array $filtros = [], int $perPage = 10)
    {
        try {
            $usuarios =  $this->usuarioRepository->findAll($filtros, $perPage);
             return [
                'message' => 'Dados listados com sucesso!',
                'data'   => $usuarios
            ];

        } catch (Throwable $e) {
            Log::error('Erro ao listar usuários' . $e->getMessage());
            throw $e;
        }
    }
    public function excluirUsuario($request, int $id)
    {
        try {
            $idUserExcluido = User::findOrFail($id);

            if (Gate::denies('delete', $idUserExcluido)) {
                throw new \Exception('Somente Administradores podem excluir perfis de outros usuários.',
                403);
            }
            $usuarioExcluido = $this->usuarioRepository->delete($id);

             return [
                'message' => 'Usuário excluido com sucesso!',
                'data'   => $usuarioExcluido
            ];
        } catch (Throwable $e) {
            Log::error('Erro ao excluir usuário ' . $e->getMessage());
            throw $e;
        }
    }
    public function buscarUsuario(int $id)
    {
        try {
            $usuario =  $this->usuarioRepository->findById($id);
               return [
                'message' => 'Dados listados com sucesso!',
                'data'   => $usuario
            ];
        } catch (Throwable $e) {
            Log::error('Erro ao buscar usuário id: '.$id.'.' . $e->getMessage());
            throw $e;
        }
    }
}
