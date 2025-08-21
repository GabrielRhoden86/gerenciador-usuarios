<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class  FindUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'   => 'sometimes|string|max:255',
            'cpf'    => 'sometimes|string|size:11',
            'turma'  => 'sometimes|string|max:100',
            'status' => 'sometimes|string|in:Pendente,Aprovado,Cancelado',
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.size'        => 'O CPF deve conter exatamente 11 dígitos.',
            'status.in'       => 'O status deve ser Pendente, Aprovado ou Cancelado.',
            'nome.string'     => 'O nome deve ser uma string.',
            'turma.string'    => 'A turma deve ser uma string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no FiltroAlunoRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação nos filtros.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
