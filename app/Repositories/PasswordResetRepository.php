<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetRepository
{
    public function storeToken(string $email, string $token):void
    {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    public function validateToken(string $email, string $token): void
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 60) {
            throw new \Exception('Token inválido ou expirado.');
        }
    }

    public function saveNewPassword(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new \Exception('Usuário não encontrado.');
        }
        $user->password = Hash::make($password);
        $this->deleteToken($email);
        return $user->save();
    }

    private function deleteToken(string $email): void
    {
       DB::table('password_reset_tokens')->where('email', $email)->delete();
    }
}
