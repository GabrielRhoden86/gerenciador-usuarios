<?php
namespace App\Policies;
use App\Enums\PerfilUsuario;
use App\Models\User;

class UsuarioPolicy
{
    public function create(User $user): bool
    {
        return $user->role_id === PerfilUsuario::ADMIN->value;
    }

    public function update(User $user, User $model): bool
    {
        return $user->role_id === PerfilUsuario::ADMIN->value || $user->id === $model->id;
    }

    public function delete(User $user): bool
    {
        return $user->role_id === PerfilUsuario::ADMIN->value;
    }
}
