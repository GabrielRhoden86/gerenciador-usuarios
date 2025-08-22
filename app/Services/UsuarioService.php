<?php

namespace App\Services;
use Throwable;
use App\Enums\PerfilUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\UsuarioRepository;
use App\Services\NotificacaoService;
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
             $permissaoNegada = $this->verificarPermissaoUsuario('alterar');
              if($permissaoNegada){
                return response()->json('Somente Administradores podem alterar perfil de usuários', 403);
            }
            $usuario = $this->usuarioRepository->create( $dados);
            Log::info("Novo usuário cadastrado com sucesso", ['id' => $usuario->id]);
            return $usuario;
        } catch (Throwable $e) {
            Log::error("Erro ao cadastrar usuário: " . json_encode($dados['nome']) . " " . $e->getMessage());

            throw $e;
        }
    }
    public function editarUsuario(array $dados, int $id)
    {
        try {
            $permissaoNegada = $this->verificarPermissaoUsuario('alterar');
              if($permissaoNegada){
                return response()->json('Somente Administradores podem alterar perfil de usuários', 403);
            }
            $usuarioAtualizado = $this->usuarioRepository->update($dados, $id);
            Log::info("Dados do usuário id: ".$id." editados com sucesso!.");
            return $usuarioAtualizado;

        } catch (Throwable $e) {
            Log::error("Erro ao atualizar aluno (ID: {$id}) - service: " . $e->getMessage());
            throw $e;
        }
    }
    public function listarUsuarios(array $filtros = [])
    {
        try {
            return $this->usuarioRepository->findAll($filtros);
        } catch (Throwable $e) {
            Log::error('Erro ao listar usuários' . $e->getMessage());
            throw $e;
        }
    }
    public function excluirUsuario($request, int $id)
    {
        try {
            $permissaoNegada = $this->verificarPermissaoUsuario('alterar');
              if($permissaoNegada){
                return response()->json('Somente Administradores podem alterar perfil de usuários', 403);
            }
             $usuario = $this->usuarioRepository->delete($id);
             Log::info("Usuário id: ".$id." excluído com sucesso.");
             return $usuario;
        } catch (Throwable $e) {
            Log::error('Erro ao excluir usuário ' . $e->getMessage());
            throw $e;
        }
    }
    public function buscaUsuario(int $id)
    {
        try {
            return $this->usuarioRepository->findById($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar usuário id: '.$id.'.' . $e->getMessage());
            throw $e;
        }
    }

    private function verificarPermissaoUsuario($acao)
    {
        $usuarioAuth = Auth::user();
        if ($usuarioAuth->role_id === PerfilUsuario::USUARIO_PADRAO->value) {
            // Log::warning(message: "Permissão negada: Usuário ID $usuarioAuth  tentou $acao o perfil de outro usuário.");
        return response()->json(['message' => 'Erro interno ao atualizar usuário.']);

        }
    }
}
