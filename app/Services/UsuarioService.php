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
{    protected UsuarioRepository $usuarioRepository;
    protected NotificacaoService $notificacaoService;


    public function __construct(
        UsuarioRepository $usuarioRepository,
        NotificacaoService $notificacaoService,

    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->notificacaoService = $notificacaoService;
    }
    public function cadastrarUsuario(array $dados)
    {
        try {
            $usuario = $this->usuarioRepository->create(data: $dados);
            Log::info("Novo usuário cadastrado com sucesso", ['id' => $usuario->id]);
            return $usuario;
        } catch (Throwable $e) {
            Log::error('Erro ao cadastrar usuário - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function editarUsuario(array $dados, int $id)
    {
        try {

         if ($permissaoNegada = $this->verificarPermissaoUsuario()) return $permissaoNegada;
            $usuario = $this->usuarioRepository->findById($id);
            $usuarioNome = $usuario->nome;

            $usuarioAtualizado = $this->usuarioRepository->update($dados, $id);
            Log::info("Dados do usuário {$usuarioNome} editados com sucesso!.");
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
            Log::error('Erro ao listar alunos - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function excluirUsuario(int $id)
    {
       try {

            if ($permissaoNegada = $this->verificarPermissaoUsuario()) return $permissaoNegada;

            // $usuario = User::findOrFail($id);
            $this->usuarioRepository->delete($id);
            Log::info("Usuário  excluído com sucesso.");
        } catch (Throwable $e) {
            Log::error('Erro ao excluir usuário - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function buscaUsuario(int $id)
    {
        try {
            return $this->usuarioRepository->findById($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }

    private function verificarPermissaoUsuario()
    {
        $usuarioAutenticado = Auth::user();
        if ($usuarioAutenticado->role_id === PerfilUsuario::USUARIO_PADRAO->value) {
            return response()->json([
                'message' => 'Você não tem permissão para alterar o perfil do Usuário.'
            ], 403);
        }
        return null;
    }
}
