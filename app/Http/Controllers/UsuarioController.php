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
            $dadosValidados = $request->validated();
            $cadastro = $this->usuarioService->cadastrarUsuario($dadosValidados);
            return response()->json([
                'message' => $cadastro['message'],
                'data' => $cadastro['data']
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['message' => $e->getMessage()],
         $e->getCode());
        }
    }
    public function editarUsuario(UpdateUsuarioRequest $request, int $id)
    {
        try {
            $dadosValidados = $request->validated();
            $atualizacao = $this->usuarioService->editarUsuario($dadosValidados, $id);

            return response()->json([
                'message' => $atualizacao['message'],
                'data' => $atualizacao['data']
            ]);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()],
         $e->getCode());
        }
    }
    public function listarUsuarios(FindUsuarioRequest $request)
    {
        try {
            $dadosValidados = $request->validated();
            $perPage = $request->query('per_page', default: 10);
            $usuarios = $this->usuarioService->listarUsuarios($dadosValidados, $perPage);

            return response()->json([
                'message' => $usuarios['message'],
                'data' => $usuarios['data']
            ]);
          } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()],
         $e->getCode());
        }
    }
    public function excluirUsuario(DeleteUsuarioRequest $request, int $id)
    {
        try {
            $dadosValidados = $request->validated();
            $usuarioExcluido = $this->usuarioService->excluirUsuario($dadosValidados, $id);

          return response()->json([
                'message' => $usuarioExcluido['message'],
                'data' => $usuarioExcluido['data']
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['message' => $e->getMessage()],
         $e->getCode());
        }
    }
    public function buscarUsuario(int $id)
    {
        try {
            $usuario = $this->usuarioService->buscarUsuario($id);
            return response()->json([
                'message' => $usuario['message'],
                'data' => $usuario['data']
            ]);
            } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()],
         $e->getCode());
        }
    }
}
