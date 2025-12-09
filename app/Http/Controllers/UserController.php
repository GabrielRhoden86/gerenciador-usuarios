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
            $this->authorize('create', User::class);
            $validateData = $request->validated();
            $cadastro = $this->service->createUser($validateData);
            return response()->json([
                'message' => 'Cadastro realizado com sucesso!',
                'data' => $cadastro
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()]
         );
        }
    }
    public function update(UpdateUsuarioRequest $request, int $id)
    {
        try {
            $this->authorize('update', User::class);
            $validateData = $request->validated();
            $user = $this->service->editUser($validateData, $id);

            return response()->json([
                'message' => 'Dados atualizados com sucesso!',
                'data' => $user
            ]);
        } catch (Throwable $e) {
            return response()->json(
             ['error' => $e->getMessage()]
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
            ['error' => $e->getMessage()],
         500);
        }
    }
    public function listAll()
    {
          try {
            $users = $this->service->getAllUsers();
            return response()->json([
                'message' => 'Dados listados com sucesso!',
                'data' => $users,
            ]);
          } catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()],
         );
        }
    }
    public function destroy(int $id)
    {
        try {
        $this->authorize('delete', User::class);
          $user = $this->service->deleteUser( $id);
          return response()->json([
                'message' => 'Usuário excluido com sucesso!',
                'data' => $user
            ]);
         } catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()],
         );
        }
    }
    public function show(int $id)
    {
        try {
            $user = $this->service->showUser($id);
            return response()->json([
                'message' => 'Dados listados com sucesso!',
                'data' => $user
            ]);
        } catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()],500);
        }
    }
}
