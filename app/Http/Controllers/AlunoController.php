<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlunoRequest;
use App\Http\Requests\UpdateAlunoRequest;
use App\Http\Requests\FiltroAlunoRequest;
use App\Services\UsuarioService;
use Throwable;
use Exception;

class AlunoController extends Controller
{
    protected $usuarioService;
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }
    public function criarUsuario(StoreAlunoRequest $request)
    {
        try {
            $usuario = $this->usuarioService->criarUsuario($request->validated());
            return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'data' =>  $usuario ], 201);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao cadastrar usuário.',],
             500);
        }
    }

  public function aditarAluno(UpdateAlunoRequest $request, int $id)
    {
        try {
            $usuario = $this->usuarioService->aditarAluno($request->validated(), $id);
            return response()->json(['message' => 'Dados do usuário atualizado com sucesso!','data' => $usuario],
            200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao atualizar usuário.'],
            500);
        }
    }

    public function listarUsuarios(FiltroAlunoRequest $request)
    {
        try {
            $usuario = $this->usuarioService->listarUsuarios($request->all());
            return response()->json(['message' => 'Usuários listados sucesso!', 'data' => $usuario], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => 'Erro interno ao listar usuários.'],
             500);
        }
    }
    public function buscarAluno(int $id)
    {
        try {
            $aluno = $this->usuarioService->buscarAluno($id);
                return response()->json(['message' => 'Busca realizada com sucesso!', 'data' => $aluno],
                200);
            } catch (Throwable $e) {
                return response()->json(['message' => 'Nenhum aluno encontrado.'],
                 500);
            }
    }
  }
