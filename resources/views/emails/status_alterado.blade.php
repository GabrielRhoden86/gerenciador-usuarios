@component('mail::message')
# Notificação de Alteração de Status

Aluno {{ $nomeAluno }}, ID **{{ $alunoId }}** teve o status alterado.

- Status anterior: {{ $statusAnterior }}
- Novo status: {{ $statusNovo }}

<br>
{{ config('app.name') }}
@endcomponent
