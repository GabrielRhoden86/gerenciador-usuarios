<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'id' => 'required|integer|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $userId,
            'role_id' => 'sometimes|integer|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.sometimes' => 'O campo nome é opcional, mas se informado deve ser válido.',
            'name.string' => 'O campo nome deve ser um texto.',
            'name.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'email.sometimes' => 'O campo email é opcional mas deve ser válido.',
            'email.string' => 'O email deve ser um texto válido.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode ultrapassar 255 caracteres.',
            'email.unique' => 'Este e-mail já está sendo utilizado.',

            'role_id.sometimes' => 'O campo role_id é opcional mas deve ser válido.',
            'role_id.integer' => 'O campo role_id deve ser um número inteiro.',
            'role_id.exists' => 'A role_id selecionada não existe.',

            'id.required' => 'O campo id não existe ou é inválido!',
            'id.integer'  => 'O id deve ser um número inteiro válido.',
            'id.exists'   => 'O usuário informado não existe no sistema.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no UpdateUsuarioRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }


    //incluir o id da rota nos dados validados
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
