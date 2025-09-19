<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/reset-senha', [ForgotPasswordController::class, 'enviarLink'])->name('enviarLink');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('usuarios')->group(function () {
        Route::post('/cadastrar', [UsuarioController::class, 'cadastrarUsuario']);
        Route::patch('/editar/{id}', [UsuarioController::class, 'editarUsuario']);
        Route::get('/listar', [UsuarioController::class, 'index']);
        Route::delete('/excluir/{id}', [UsuarioController::class, 'excluirUsuario']);
        Route::get('/buscar/{id}', [UsuarioController::class, 'buscarUsuario']);
    });
});
