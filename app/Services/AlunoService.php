<?php

namespace App\Services;
use Throwable;
use App\Enums\Perfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\AlunoRepository;
use App\Services\NotificacaoService;

class AlunoService
{
    protected $alunoRepository;
    protected $notificacaoService;

    public function __construct(AlunoRepository $alunoRepository, NotificacaoService $notificacaoService)
    {
        $this->alunoRepository = $alunoRepository;
        $this->notificacaoService = $notificacaoService;
    }
    public function criarAluno(array $dados)
    {
        try {
            return $this->alunoRepository->create($dados);
        } catch (Throwable $e) {
            Log::error('Erro ao cadastrar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function aditarAluno(array $dados, int $id)
    {
        try {
            $aluno = $this->alunoRepository->findById($id);
            $nomeAluno = $aluno->nome;
            $alunoId = $aluno->id;
            $usuario = Auth::user();
            $emailUsuario = $usuario->email;

            if (isset($dados['status']) && $usuario->perfil === Perfil::FUNCIONARIO->value) {
                return response()->json(['message' =>
                 'Funcionários não têm permissão para alterar o status do aluno.'], 403);
            }
            $alunoAtualizado = $this->alunoRepository->update($dados, $id);
            $statusAnterior = $aluno->status;
            $statusNovo = $alunoAtualizado->status;

            $dadosNotificacao = [
                "nomeAluno" => $nomeAluno,
                "alunoId" => $alunoId,
                "statusAnterior" => $statusAnterior,
                "statusNovo" => $statusNovo,
                "emailUsuario" => $emailUsuario
            ];

            if ($statusAnterior !== $statusNovo && in_array($statusNovo, ['Aprovado', 'Cancelado'])) {
                  $this->notificacaoService->notificarGestorAlteracaoStatus($dadosNotificacao);
            }
            return $alunoAtualizado;

        } catch (Throwable $e) {
            Log::error('Erro ao atualizar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function listarAlunos(array $filtros = [])
    {
        try {
            return $this->alunoRepository->findAll($filtros);
        } catch (Throwable $e) {
            Log::error('Erro ao listar alunos - service: ' . $e->getMessage());
            throw $e;
        }
    }
    public function buscarAluno(int $id)
    {
        try {
            return $this->alunoRepository->findById($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar aluno - service: ' . $e->getMessage());
            throw $e;
        }
    }
}
