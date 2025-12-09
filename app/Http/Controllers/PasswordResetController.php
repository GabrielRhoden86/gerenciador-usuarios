<?php

namespace App\Http\Controllers;
use App\Services\PasswordResetService;
use Throwable;
use Illuminate\Http\Request;

class  PasswordResetController extends Controller
{
    protected $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }
    public function sendLink(Request $request)
    {
        try{
           $this->service->sendLinkMail($request->email);
           return response()->json(['message' => 'Link de reset enviado!']);

         }catch (Throwable $e) {
            return response()->json(
            ['error' => $e->getMessage()]);
        }
    }

    public function reset(Request $request)
    {
        try {
         $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
            ]);
           $this->service->resetPassword($request);
           return response()->json(['message' => 'Senha redefinida com sucesso']);

        } catch (Throwable $e) {
          return response()->json(
          ['error' => $e->getMessage()]);
        }
    }
}


