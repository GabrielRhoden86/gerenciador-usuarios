<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreAlunoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:alunos,cpf',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'turma' => 'required|string|max:255',
            'status' => 'required|in:Pendente,Aprovado,Cancelado',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.date_format' => 'A data deve estar no formato YYYY-MM-DD.',
            'turma.required' => 'O campo turma é obrigatório.',
            'status.in' => 'O status deve ser Pendente, Aprovado ou Cancelado.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no StoreAlunoRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
