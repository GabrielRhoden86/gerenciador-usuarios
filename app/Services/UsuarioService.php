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
            $permissaoNegada = $this->verificarPermissaoUsuario('cadastrar');
            if ($permissaoNegada) {
                return response()->json('Somente Administradores podem cadastrar perfil de usuários', 403);
            }

            if (empty($dados['password'])) {
                $provisionalPassword = Str::random(8);
                $this->notificacaoService->notificarUsuarioSenhaProvisoria($dados['email'], $provisionalPassword);
                $dados['password'] = $provisionalPassword;
            }

            $dados['password'] = Hash::make($dados['password']);
            $usuario = $this->usuarioRepository->create($dados);

            return $usuario;
        } catch (Throwable $e) {
            Log::error("Erro ao cadastrar usuário: " . json_encode($dados['name'] ?? null) . " - " . $e->getMessage());
            throw $e;
        }
    }

public function editarUsuario(array $dados, int $id)
{
    try {
        $usuarioAuth = Auth::user();

        if ($this->verificarPermissaoUsuario('alterar') && $id !== $usuarioAuth->id) {
            Log::warning("Permissão negada: Usuário ID {$usuarioAuth->id} tentou alterar o perfil do usuário ID {$id}.");
            return response()->json('Somente Administradores podem alterar perfis de outros usuários.', 403);
        }
        if (isset($dados['password']) && !empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        $usuarioAtualizado = $this->usuarioRepository->update($dados, $id);
        Log::info("Dados do usuário ID: ".$id." editados com sucesso pelo usuário ID: ".$usuarioAuth->id.".");
        return $usuarioAtualizado;

    } catch (Throwable $e) {
        Log::error("Erro ao atualizar usuário (ID: {$id}) - service: " . $e->getMessage());
        throw $e;
    }
}

    public function listarUsuarios(array $filtros = [], int $perPage = 10)
    {
        try {
            return $this->usuarioRepository->findAll($filtros, $perPage);
        } catch (Throwable $e) {
            Log::error('Erro ao listar usuários' . $e->getMessage());
            throw $e;
        }
    }
    public function excluirUsuario($request, int $id)
    {
        try {
            $permissaoNegada = $this->verificarPermissaoUsuario('excluir');
            if($permissaoNegada){
                return response()->json('Somente Administradores podem excluir usuários', 403);
            }
             $usuarioAuth = Auth::user();
             $usuarioExcluido = $this->usuarioRepository->delete($id);
             Log::info("Usuário id: ".$id." excluído com sucesso pelo administrador: ".$usuarioAuth->id.".");
            return $usuarioExcluido;
        } catch (Throwable $e) {
            Log::error('Erro ao excluir usuário ' . $e->getMessage());
            throw $e;
        }
    }
    public function buscarUsuario(int $id)
    {
        try {
            return $this->usuarioRepository->findById($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar usuário id: '.$id.'.' . $e->getMessage());
            throw $e;
        }
    }
   private function verificarPermissaoUsuario($acao): bool
    {
      $usuarioAuth = Auth::user();
      return $usuarioAuth->role_id === PerfilUsuario::USUARIO_PADRAO->value;
    }
}
