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
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function store(StoreUsuarioRequest $request)
    {
        try {

            $this->authorize('create', User::class);
            $validateData = $request->validated();
            $cadastro = $this->userService->createUser($validateData);
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
            $user = $this->userService->editUser($validateData, $id);

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
            $users = $this->userService->getAllUsersList($validateData, $perPage);

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
            $users = $this->userService->getAllUsers();
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
          $user = $this->userService->deleteUser( $id);
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
            $user = $this->userService->showUser($id);
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
