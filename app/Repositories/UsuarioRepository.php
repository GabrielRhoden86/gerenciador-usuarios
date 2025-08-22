<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
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

    public function findAll(array $filtros = []): Collection
    {
        return User::query()
            ->select('name', 'email')
            ->when(!empty($filtros['name']), fn($query) =>
                $query->where('name', 'like', '%' . $filtros['name'] . '%'))
            ->when(!empty($filtros['email']), fn($query) =>
                $query->where('email', $filtros['email']))
             ->when(!empty($filtros['role_id']), fn($query) =>
                $query->where('role_id', $filtros['role_id']))
            ->get();
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
