<x-mail::message>
# Redefinição de Senha

Olá, {{ $user->name }}.

Você está recebendo este e-mail porque foi solicitada uma redefinição de senha para sua conta.

Clique no botão abaixo para concluir o processo:

<x-mail::button :url="$resetUrl" color="primary">
Redefinir Minha Senha
</x-mail::button>

Se você não solicitou esta redefinição, nenhuma ação adicional é necessária.

Obrigado,
{{ config('app.name') }}
</x-mail::message>
