<?php

namespace App\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;


class UsuarioRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update( array $data, int $id): User
    {
        $usuario = User::findOrFail($id);
        $usuario->update($data);
        return $usuario;
    }
    public function findAll(array $filtros = [], int $perPage = 10): array
    {
        $query = User::query()
            ->select('id', 'name', 'email', 'role_id', 'created_at', 'updated_at');

        if (!empty($filtros['name'])) {
            $query->where('name', 'like', '%' . $filtros['name'] . '%');
        }

        if (!empty($filtros['email'])) {
            $query->where('email', 'like', '%' . $filtros['email'] . '%');
        }

        if (!empty($filtros['role_id'])) {
            $query->where('role_id', $filtros['role_id']);
        }

        $paginacao = $query->paginate(perPage: $perPage);
        $todos = User::select('id', 'name')->limit(500)->get();
        
        return [
            'paginacao' => $paginacao,
            'todos'     => $todos,
        ];
    }
    public function delete(int $id): bool|null
    {
       $user = User::findOrFail($id);
       return $user->delete();
    }
    public function findById($id): User
    {
        return User::findOrFail($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
