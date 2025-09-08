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
            'id' => 'sometimes|integer|max:255',
            'name' => 'sometimes|max:255',
            'email' => 'sometimes|max:255',
            'role_id' => 'sometimes|nullable|integer|exists:roles,id',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'id.string' => 'O id deve ser um número válido.',
            'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',
            'email.string' => 'O email deve ser um texto válido.',
            'email.max' => 'O e-mail não pode ultrapassar 255 caracteres.',
            'role_id.integer' => 'O campo role_id deve ser um número inteiro.',
            'role_id.exists' => 'A role_id selecionada não existe.',
            'per_page.integer' => 'O valor de per_page deve ser um número.',
            'per_page.min' => 'O valor mínimo de per_page é 1.',
            'per_page.max' => 'O valor máximo de per_page é 100.',
        ];
    }

   protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no FindUsuarioRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação nos filtros.',
            'errors' => $validator->errors(),
        ], 422));
    }
    }
