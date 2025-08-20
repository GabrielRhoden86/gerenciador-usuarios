<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Http\Requests\FiltroAlunoRequest;
use App\Services\AlunoService;
use Throwable;
use Exception;

class AlunoController extends Controller
{
    protected $alunoService;
    public function __construct(AlunoService $alunoService)
    {
        $this->alunoService = $alunoService;
    }
    public function criarAluno(StoreAlunoRequest $request)
    {
        try {
            $aluno = $this->alunoService->criarAluno($request->validated());
            return response()->json(['message' => 'Aluno cadastrado com sucesso!', 'data' => $aluno], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao cadastrar aluno.'], 500);
        }
    }

  public function aditarAluno(UpdateAlunoRequest $request, int $id)
    {
        try {
            $aluno = $this->alunoService->aditarAluno($request->validated(), $id);
            return response()->json(['message' => 'Dados do aluno atualizado com sucesso!','data' => $aluno],
            200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao atualizar aluno.', 'error'=> $e->getMessage()],
            500);
        }
    }

    public function listarAlunos(FiltroAlunoRequest $request)
    {
        try {
            $aluno = $this->alunoService->listarAlunos($request->all());
            return response()->json(['message' => 'Alunos listados sucesso!', 'data' => $aluno], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao listar aluno.'], 500);
        }
    }
    public function buscarAluno(int $id)
    {
        try {
            $aluno = $this->alunoService->buscarAluno($id);
                return response()->json(['message' => 'Busca realizada com sucesso!', 'data' => $aluno],
                200);
            } catch (Throwable $e) {
                return response()->json(['message' => 'Nenhum aluno encontrado.', 'error'=> $e->getMessage()],
                 500);
            }
    }
  }
