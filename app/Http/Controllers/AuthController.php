<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'message' => 'Login bem-sucedido.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }
    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json(['message' => 'Logout bem-sucedido']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao realizar logout',
             $e->getMessage()], 500);
        }
    }
    public function profile()
    {
        $user = auth('api')->user();
        if ($user) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'permissao' => $user->role_id,
            ], 200);
        }

        return response()->json(['error' => 'Não autenticado'], 401);
    }

    public function refresh()
    {
        try {
            $newToken = auth('api')->refresh();
            return response()->json([
                'message' => 'Token atualizado com sucesso',
                'access_token' => $newToken,
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível atualizar o token.'], 401);
        }
    }
    public function emailVerification(Request $request)
    {
        $authUser = Auth::user();

        if (!$authUser) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $user = \App\Models\User::find($authUser->id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'E-mail já verificado.'], 200);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'E-mail verificado com sucesso.'], 200);
    }

}
