<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/criar-usuario', action: [AlunoController::class, 'criarUsuario']);
    Route::patch('/editar-aluno/{id}', [AlunoController::class, 'aditarAluno']);
    Route::get('/listar-usuarios', [AlunoController::class, 'listarUsuarios']);
    Route::get('/buscar-aluno/{id}', [AlunoController::class, 'buscarAluno']);
});
