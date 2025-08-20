<?php

namespace App\Services;
use Throwable;
use App\Enums\Perfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\UsuarioRepository;
use App\Services\NotificacaoService;

class UsuarioService
{
    protected $usuarioRepository;
    protected $notificacaoService;

    public function __construct(UsuarioRepository $usuarioRepository, NotificacaoService $notificacaoService)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->notificacaoService = $notificacaoService;
    }
    public function criarUsuario(array $dados)
    {

        try {

            // $dados['password'] = bcrypt($dados['password']);

            $usuario = $this->usuarioRepository->create(data: $dados);
            Log::info("Novo usuário cadastrado com sucesso", ['id' => $usuario->id]);
            return $usuario;
        } catch (Throwable $e) {
            Log::error('Erro ao cadastrar usuário - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function aditarAluno(array $dados, int $id)
    {
        try {
            $usuario = $this->usuarioRepository->findById($id);
            $nomeUsuario = $usuario->nome;
            $usuarioId = $usuario->id;
            $usuarioAutenticado = Auth::user();
            $emailUsuarioAutenticado = $usuarioAutenticado->name;

            if (isset($dados['status']) && $usuarioAutenticado->perfil === Perfil::FUNCIONARIO->value) {
                return response()->json([
                    'message' => 'Funcionários não têm permissão para alterar o status do aluno.'
                ], 403);
            }

            $usuarioAtualizado = $this->usuarioRepository->update($dados, $id);
            Log::info("Dados do usuário {$nomeUsuario} (ID: {$usuarioId}) editados com sucesso por {$emailUsuarioAutenticado}.");
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
    public function buscarAluno(int $id)
    {
        try {
            return $this->usuarioRepository->findById($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }
}
