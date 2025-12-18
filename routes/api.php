<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use \App\Http\Middleware\EnsureEmailIsVerified;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/reset-password-email', [PasswordResetController::class, 'sendLink']);
Route::post('/reset-password', action: [PasswordResetController::class, 'reset']);
Route::post('/email-verification', [AuthController::class, 'emailVerification'])->middleware('auth:api');

Route::middleware(['auth:api', EnsureEmailIsVerified::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', action: [AuthController::class, 'profile']);
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/todos', [UserController::class, 'listAll']);
        Route::get('/buscar/{id}', [UserController::class, 'show']);
        Route::post('/cadastrar', [UserController::class, 'store']);
        Route::patch('/editar/{id}', [UserController::class, 'update']);
        Route::delete('/excluir/{id}', [UserController::class, 'destroy']);
    });
});

