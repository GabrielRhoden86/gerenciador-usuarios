<?php

namespace App\Http\Controllers;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function sendLink(Request $request, PasswordResetService $service)
    {
        try{
           $service->sendLinkMail($request->email);
           return response()->json(['message' => 'Link de reset enviado!']);

         }catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()],500);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->where('token', $request->token)
                    ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 60) {
            return response()->json(['message' => 'Token inválido ou expirado'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Senha redefinida com sucesso']);
    }
}


