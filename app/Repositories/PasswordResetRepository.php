<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class PasswordResetRepository
{
    public function storeToken(string $email, string $token)
    {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }
}
