<?php

namespace App\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
    public function delete(User $user): bool
    {
       return $user->delete();
    }
    public function paginateUsers(array $filtros = [], int $perPage = 10): LengthAwarePaginator
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

        return $query->paginate(perPage: $perPage);
    }
    public function findAllUsers(): Collection
    {
        return User::query()->select('id', 'name')->get();
    }
    public function findByUser(int $id): User
    {
        return User::findOrFail($id);
    }
    public function findByEmail(string $email): ?User
    {
        // Se não encontrar, retorna null (conforme o ?User)
        return User::where('email', $email)->first();
    }
}
