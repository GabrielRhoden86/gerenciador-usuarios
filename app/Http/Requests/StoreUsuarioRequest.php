<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role_id' => 'required|integer|in:1,2',
            'email' => 'required|string|email|max:255|unique:users,email',
        ];
    }

    public function messages(): array
        {
            return [
                'name.required'     => 'O campo nome é obrigatório.',
                'email.required'    => 'O campo e-mail é obrigatório.',
                'email.email'       => 'O campo e-mail deve ser válido.',
                'email.unique'      => 'O e-mail informado já está em uso.',
                'role_id.required'  => 'O campo perfil é obrigatório.',
                'role_id.in'        => 'O perfil selecionado deve ser admin ou user.',
            ];
        }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no StoreUsuarioRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
