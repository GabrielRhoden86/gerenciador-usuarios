<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
 public function login(Request $request)
 {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 2440,
                'user' => [
                 'id' => $user->id,
                'name' => $user->name,
                ],
        ]);
  }

 public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['error' => 'Token não fornecido'], 400);
            }
            JWTAuth::setToken($token)->invalidate();
            return response()->json([
                'message' => 'Logout realizado com sucesso!'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Falha ao realizar logout, token inválido'
            ], 500);
        }
    }
}
