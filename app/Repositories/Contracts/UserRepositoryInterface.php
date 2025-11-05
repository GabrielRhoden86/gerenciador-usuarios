<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

// Definição da Interface
interface UserRepositoryInterface
{
    // C.R.U.D. Básico
    public function create(array $data): User;
    public function updateUser(User $user, array $data): User;
    public function delete(User $user): bool;

    // Métodos de Busca
    public function findByUser(int $id): User; // Renomeei o parâmetro para int
    public function findByEmail(string $email): ?User; // Corrigido para retornar null se não encontrar

    // Métodos de Listagem/Paginação
    public function paginateUsers(array $filtros = [], int $perPage = 10): LengthAwarePaginator;
    public function findAllUsers(): Collection;
}
