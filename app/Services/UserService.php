<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserService
{
    protected UserRepository $userRepository;
    protected NotificationService $notificationService;

    public function __construct(UserRepository $userRepository, NotificationService $notificationService) {
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
    }
    public function createUser(array $data)
    {
        if (empty($data['password'])) {
            $provisionalPassword = Str::random(8);
            $this->notificationService->notifyUserTemporaryPassword($data['email'], $provisionalPassword);
            $data['password'] = $provisionalPassword;
        }
            $data['password'] = Hash::make($data['password']);
            return $this->userRepository->create($data);
    }
    public function editUser(array $data, int $id)
    {
        $user = User::findOrFail($id);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->updateUser($user, $data);
    }
    public function getAllUsersList(array $filtros = [], int $perPage = 10)
    {
       return $this->userRepository->paginateUsers($filtros, $perPage);
    }
    public function getAllUsers()
    {
      return $this->userRepository->findAllUsers();
    }
    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        return $this->userRepository->delete($user);
    }
    public function showUser(int $id)
    {
       return  $this->userRepository->findByUser($id);
    }
}
