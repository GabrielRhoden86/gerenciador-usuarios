<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Requests\DeleteUsuarioRequest;
use App\Http\Requests\FindUsuarioRequest;
use App\Services\UsuarioService;
use Throwable;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    protected $usuarioService;
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }
    public function cadastrarUsuario(StoreUsuarioRequest $request)
    {
        try {
            $usuario = $this->usuarioService->cadastrarUsuario($request->validated());
            return response()->json(['message' => 'Usuário cadastrado', 'data' =>  $usuario ], 201);
        } catch (Throwable) {
            return response()->json(['message' => 'Erro ao cadastrar usuário.',],
             500);
        }
    }

    public function editarUsuario(UpdateUsuarioRequest $request, int $id)
    {
        try {
            $usuario = $this->usuarioService->editarUsuario($request->validated(), $id);
            return response()->json(['message' => 'Atualização usuário:','data' => $usuario],
            200);
        } catch (Throwable) {
            return response()->json(['message' => 'Erro interno ao atualizar usuário.'],
            500);
        }
    }

    public function listarUsuarios(FindUsuarioRequest $request)
    {
        try {
            $usuario = $this->usuarioService->listarUsuarios($request->all());
            return response()->json(['message' => 'Lista usuários:', 'data' => $usuario], 200);
        } catch (Throwable) {
            return response()->json(['message' => 'Erro interno ao listar usuários.'],
             500);
        }
    }

    public function excluirUsuario(DeleteUsuarioRequest $request, int $id)
    {
        try {
           $usuario = $this->usuarioService->excluirUsuario ($request->validated(), $id);
            return response()->json(['message' => 'Exclusão usuário:!','data' => $usuario], 200);
        } catch (Throwable) {
            return response()->json(['message' => 'Falha ao excluir usuário.'],
             500);
        }
    }
    public function buscaUsuario(int $id)
    {
        try {
            $aluno = $this->usuarioService->buscaUsuario($id);
                return response()->json(['message' => 'Busca usuários:', 'data' => $aluno],
                200);
            } catch (Throwable) {
                return response()->json(['message' => 'Nenhum aluno encontrado.'],
                 500);
            }
    }
  }
