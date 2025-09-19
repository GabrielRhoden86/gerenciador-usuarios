<?php

namespace App\Http\Controllers;
use App\Services\ResetSenhaService;
use Throwable;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function enviarLink(Request $request, ResetSenhaService $service)
    {
        try{
           $service->enviarLink($request->email);
           return response()->json(['message' => 'Link de reset enviado!']);

         }catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()],$e->getCode());
        }
    }
}


