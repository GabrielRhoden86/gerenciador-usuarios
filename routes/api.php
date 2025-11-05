<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password-email', [PasswordResetController::class, 'sendLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/todos', [UserController::class, 'listAll']);
        Route::get('/buscar/{id}', [UserController::class, 'show']);
        Route::post('/cadastrar', [UserController::class, 'store']);
        Route::patch('/editar/{id}', [UserController::class, 'update']);
        Route::delete('/excluir/{id}', [UserController::class, 'destroy']);
    });
});
