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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            // 'cpf' => 'required|string|size:11|unique:alunos,cpf',
            // 'data_nascimento' => 'required|date_format:Y-m-d',
            // 'turma' => 'required|string|max:255',
            // 'status' => 'required|in:Pendente,Aprovado,Cancelado',
        ];
    }

        public function messages(): array
        {
            return [
                'name.required'     => 'O campo nome é obrigatório.',
                'email.required'    => 'O campo e-mail é obrigatório.',
                'email.email'       => 'O campo e-mail deve ser válido.',
                'email.unique'      => 'O e-mail informado já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min'      => 'A senha deve ter no mínimo 6 caracteres.',
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
