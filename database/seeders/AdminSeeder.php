<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Inicial',
            'email' => 'admin@exemplo.com',
            'password' => Hash::make('senha123'),
            'role_id' => 1,
        ]);
    }
}
