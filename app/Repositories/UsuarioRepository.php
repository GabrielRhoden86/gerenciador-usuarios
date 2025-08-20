<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Aluno;
use App\Models\User;

class UsuarioRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update( array $data, int $id): Aluno
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($data);
        return $aluno;
    }

    public function findAll(array $filtros = []): Collection
    {
        return User::query()
            ->select('name', 'email')
            ->when(!empty($filtros['name']), fn($query) =>
                $query->where('name', 'like', '%' . $filtros['name'] . '%'))
            ->when(!empty($filtros['email']), fn($query) =>
                $query->where('email', $filtros['email']))
            ->get();
    }


    public function findById($id): Aluno
    {
        return Aluno::findOrFail($id);
    }
}
