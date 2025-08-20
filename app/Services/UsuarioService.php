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
            $usuarioAutenticado = Auth::user();
            $nomeExecutor = $usuarioAutenticado->name;
            Log::info("Novo usuário cadastrado com sucesso pelo {$nomeExecutor}" );
            return $this->usuarioRepository->create(data: $dados);
        } catch (Throwable $e) {
            Log::error('Erro ao cadastrar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function aditarAluno(array $dados, int $id)
    {
        try {
            $aluno = $this->usuarioRepository->findById($id);
            $nomeAluno = $aluno->nome;
            $alunoId = $aluno->id;

            $usuarioAutenticado = Auth::user();
            $emailUsuarioAutenticado = $usuarioAutenticado->name;
            if (isset($dados['status']) && $usuarioAutenticado->perfil === Perfil::FUNCIONARIO->value) {
                return response()->json(['message' =>
                 'Funcionários não têm permissão para alterar o status do aluno.'], 403);
            }
            $alunoAtualizado = $this->usuarioRepository->update($dados, $id);
            // $statusAnterior = $aluno->status;
            // $statusNovo = $alunoAtualizado->status;

            // $dadosNotificacao = [
            //     "nomeAluno" => $nomeAluno,
            //     "alunoId" => $alunoId,
            //     "statusAnterior" => $statusAnterior,
            //     "statusNovo" => $statusNovo,
            //     "emailUsuario" => $emailUsuarioAutenticado
            // ];

            // if ($statusAnterior !== $statusNovo && in_array($statusNovo, ['Aprovado', 'Cancelado'])) {
            //       $this->notificacaoService->notificarGestorAlteracaoStatus($dadosNotificacao);
            // }

            Log::info("Dados do usuário {$nomeAluno} editado pelo {$emailUsuarioAutenticado} com sucesso!");
            return $alunoAtualizado;

        } catch (Throwable $e) {
            Log::error('Erro ao atualizar aluno - service: ' . $e->getMessage());
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
