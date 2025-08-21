<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use App\Models\Aluno;

class UpdateUsuarioRequest  extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email',
            // 'cpf' => 'sometimes|string|size:11|unique:alunos,cpf,' . $this->route('id'),
            // 'data_nascimento' => 'sometimes|date_format:Y-m-d',
            // 'turma' => 'sometimes|string|max:255',
            // 'status' => 'sometimes|in:Aprovado,Cancelado',
        ];
    }

    public function messages(): array
    {
        return [
              'nome.sometimes' => 'O campo nome é opcional, mas se informado deve ser válido.',
              'nome.string' => 'O campo nome deve ser um texto.',
              'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',

              'email.sometimes' => 'O campo email é opcional mas deve ser válido.',
              'email.string'   => 'O email deve ser um texto válido.',
              'email.email'    => 'Informe um endereço de e-mail válido.',
              'email.max'      => 'O e-mail não pode ultrapassar 255 caracteres.',
              'email.unique'   => 'Este e-mail já está sendo utilizado.',
            // 'cpf.unique' => 'Este CPF já está cadastrado por outro aluno.',
            // 'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            // 'status.in' => 'O status deve ser Aprovado ou Cancelado.',
            // 'data_nascimento.date_format' => 'A data deve estar no formato YYYY-MM-DD.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('Validação falhou no UpdateAlunoRequest', [
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação.',
            'errors' => $validator->errors(),
        ], 422));
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('status')) {
                $aluno = Aluno::find($this->route('id'));

                if ($aluno) {
                    if ($aluno->status === 'Aprovado' && $this->input('status') === 'Cancelado') {
                        $validator->errors()->add('status', 'Não é permitido cancelar um aluno que já está aprovado.');
                    }
                }
            }
        });
    }
}
