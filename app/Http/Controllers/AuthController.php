<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;


class AuthController extends Controller
{

public function attachJwtCookie($response, $token, $minutesLifetime)
{
    // Configuração para desenvolvimento local (HTTP)
    $secure = false; // Mude para true em produção (HTTPS)
    $sameSite = 'None';
    // Nota: 'None' pode ser representado como null ou 'none' dependendo da versão do Laravel/PHP
    return $response->cookie(
        'access_token',      // Nome
        $token,             // Valor
        $minutesLifetime,   // Duração (MINUTOS) <-- NOVO ARGUMENTO AQUI
        '/',                 // Path
        null,                // Domain
        $secure,             // Secure (false para HTTP local)
        true,                // HttpOnly
        false,               // Raw
        $sameSite            // SameSite (None)
    );
}

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

    $expiresInSeconds = auth('api')->factory()->getTTL() * 60; // Tempo em segundos
    $expiresInMinutes = $expiresInSeconds / 60; // Tempo em minutos

    $responseJson = [
        'message' => 'Login bem-sucedido.',
        'expires_in' => $expiresInSeconds,
    ];

    $response = response()->json($responseJson, 200);
    // Passe a duração em MINUTOS para a função:
    return $this->attachJwtCookie($response, $token, $expiresInMinutes);
    }

    public function logout()
    {
        auth('api')->logout();
        $response = response()->json(['message' => 'Logout bem-sucedido']);
        $cookie = cookie()->forget('jwt');
        return $response->cookie($cookie);
    }

    // Endpoint para verificar o status do usuário ou "refrescar" o token automaticamente
    public function me()
    {
        if (auth('api')->user()) {
             $user = auth('api')->user();
             return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'permissao' => $user->role_id,
            ]);
        }
        return response()->json(['error' => 'Não autenticado'], 401);
    }

    public function refresh()
    {
        // O pacote JWT do Tymon pode refrescar o token a partir do token existente no cookie.
        try {
            $newToken = auth('api')->refresh();
            $response = response()->json(['message' => 'Token atualizado com sucesso'], 200);
            // Anexamos o novo token como um novo cookie HttpOnly
            return $this->attachJwtCookie($response, $newToken);

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
