<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Requests\DeleteUsuarioRequest;
use App\Http\Requests\FindUsuarioRequest;
use App\Services\UsuarioService;
use Throwable;
use Illuminate\Support\Facades\Log;
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
            return response()->json(['message' => 'Cadastro usuário realizando com sucesso:', 'data'=>$usuario ], 201);
        } catch (Throwable) {
            return response()->json(['erro' => 'Erro ao cadastrar usuário.'],
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
            return response()->json(['erro' => 'Erro interno ao atualizar usuário.'],
            500);
        }
    }

    public function listarUsuarios(FindUsuarioRequest $request)
    {
            try {
                $perPage = $request->query('per_page', 10);
                $usuarios = $this->usuarioService->listarUsuarios($request->all(), $perPage);

                return response()->json([
                    'message' => 'Lista de usuários:',
                    'data' => $usuarios
                ], 200);
            } catch (Throwable) {
                return response()->json([
                    'erro' => 'Erro interno ao listar usuários.'
                ], 500);
            }
    }

    public function excluirUsuario(DeleteUsuarioRequest $request, int $id)
    {
        try {
           $usuario = $this->usuarioService->excluirUsuario ($request->validated(), $id);
            return response()->json(['message' => 'Exclusão usuário:','data' => $usuario], 200);
        } catch (Throwable) {
            return response()->json(['erro' => 'Falha ao excluir usuário.'],
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
                return response()->json(['erro' => 'Nenhum aluno encontrado.'],
                 500);
            }
    }
  }
