<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api'])->prefix('usuarios')
    ->group(function () {
        Route::post('/cadastrar', [UsuarioController::class, 'cadastrarUsuario']);
        Route::patch('/editar/{id}', [UsuarioController::class, 'editarUsuario']);
        Route::get('/listar', [UsuarioController::class, 'listarUsuarios']);
        Route::delete('/excluir/{id}', [UsuarioController::class, 'excluirUsuario']);
        Route::get('/buscar/{id}', [UsuarioController::class, 'buscarUsuario']);
    });
