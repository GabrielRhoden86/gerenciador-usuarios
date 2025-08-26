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

    public function findAll(array $filtros = [], int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->select('id','name', 'email','role_id','created_at','updated_at')
            ->when(!empty($filtros['name']), fn($query) =>
                $query->where('name', 'like', '%' . $filtros['name'] . '%'))
            ->when(!empty($filtros['email']), fn($query) =>
                $query->where('email', $filtros['email']))
             ->when(!empty($filtros['role_id']), fn($query) =>
                $query->where('role_id', $filtros['role_id']))
            ->paginate($perPage);
    }

    public function delete(int $id)
    {
       $user = User::findOrFail($id);
       return $user->delete();
    }
    public function findById($id): User
    {
        return User::findOrFail($id);
    }
}
