<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Requests\DeleteUsuarioRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FindUsuarioRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Throwable;

class UserController extends Controller
{
    use AuthorizesRequests;
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    public function store(StoreUsuarioRequest $request)
    {
        try {
            $validateData = $request->validated();
            $data = $this->service->createUser($validateData);
            return response()->json([
                'message' => 'Cadastro realizado com sucesso!',
                'data' => $data
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['error' => "Falha ao cadastrar usuário"],
            500
         );
        }
    }
    public function update(UpdateUsuarioRequest $request, int $id)
    {
        $userEdited = User::findOrFail($id);
        $this->authorize('update',$userEdited);

        try {
            $validateData = $request->validated();
            $data = $this->service->editUser($validateData, $id);

            return response()->json([
                'message' => 'Dados atualizados com sucesso!',
                'data' => $data
            ]);
        } catch (Throwable $e) {
            return response()->json(
             ['error' => "Falha a atualizar usuário"],
             500
         );
        }
    }
    public function index(FindUsuarioRequest $request)
    {
        try {
            $validateData = $request->validated();
            $perPage = $request->query('per_page', default: 10);
            $users = $this->service->getAllUsersList($validateData, $perPage);

            return response()->json([
                'message' => 'Dados listados com sucesso!',
                'data' => $users['data'],
            ]);
          } catch (Throwable $e) {
            return response()->json(
            ['error' => "Falha ao listar usuários"],
         500);
        }
    }
    public function listAll()
    {
        try {
            $data = $this->service->getAllUsers();
            return response()->json([
                'message' => 'Dados listados com sucesso!',
                'data' => $data,
            ]);
            } catch (Throwable $e) {
                return response()->json(
               ['error' => "Falha ao listar usuários"],
               500
            );
        }
    }
    public function destroy(int $id)
    {
      $userDeleted = User::findOrFail(id: $id);
      $this->authorize('delete', $userDeleted);
      try {
          $data = $this->service->deleteUser( $id);
          return response()->json([
                'message' => 'Usuário excluido com sucesso!',
                'data' => $data
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['error' => "Falha ao excluir usuário"],
            500
         );
        }
    }
    public function show(int $id)
    {
        $user = User::findOrFail($id);
        try {
            $data = $this->service->showUser($user->id);
            return response()->json([
                'message' => 'Dados listados com sucesso!',
                'data' => $data
            ]);
        } catch (Throwable $e) {
            return response()->json(
            ['error' => "Falha ao listar dados"],
            500);
        }
    }
}
