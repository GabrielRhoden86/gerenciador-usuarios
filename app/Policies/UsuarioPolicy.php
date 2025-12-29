<?php
namespace App\Policies;
use App\Enums\PerfilUsuario;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class UsuarioPolicy
{

    public function update(User $user, User $model): Response
    {
        $hasPermission = $user->role_id === PerfilUsuario::ADMIN->value || $user->id === $model->id;

        return $hasPermission
            ? Response::allow()
            : Response::denyWithStatus(403,
              'Você não tem permissão para editar este perfil.');
    }

    public function delete(User $user): Response
    {
        return $user->role_id === PerfilUsuario::ADMIN->value
            ? Response::allow()
            : Response::denyWithStatus(403,
              'Somente administradores podem excluir usuários.');
    }
}
