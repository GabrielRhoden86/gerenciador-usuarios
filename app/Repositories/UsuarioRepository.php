<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Aluno;

class UsuarioRepository
{
    public function create(array $data): Aluno
    {
        return Aluno::create($data);
    }

    public function update( array $data, int $id): Aluno
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($data);
        return $aluno;
    }

    public function findAll(array $filtros = []): Collection
    {
        return Aluno::query()
            ->when(!empty($filtros['nome']), fn($query) =>
                $query->where('nome', 'like', '%' . $filtros['nome'] . '%'))

            ->when(!empty($filtros['cpf']), fn($query) =>
                $query->where('cpf', $filtros['cpf']))

            ->when(!empty($filtros['data_nascimento']), fn($query) =>
                $query->whereDate('data_nascimento', $filtros['data_nascimento']))

            ->when(!empty($filtros['turma']), fn($query) =>
                $query->where('turma', $filtros['turma']))

            ->when(!empty($filtros['status']), fn($query) =>
                $query->where('status', $filtros['status']))
            ->get();
    }

    public function findById($id): Aluno
    {
        return Aluno::findOrFail($id);
    }
}
