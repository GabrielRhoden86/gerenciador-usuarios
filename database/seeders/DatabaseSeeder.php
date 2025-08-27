<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário principal
        User::create([
            'name' => 'Gabriel',
            'email' => 'gabriel@teste.com',
            'role_id' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('senha123'), // senha hash
            'remember_token' => Str::random(10),
        ]);

        // 40 usuários aleatórios
        for ($i = 1; $i <= 40; $i++) {
            User::create([
                'name' => "User$i",
                'email' => "user$i@teste.com",
                'role_id' => rand(1, 3), // roles aleatórias de 1 a 3
                'email_verified_at' => now(),
                'password' => Hash::make('senha123'), // mesma senha para teste
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
