@component('mail::message')
# Cadastro Concluído com Sucesso!!!

Olá,

Sua conta foi criada. Por favor, use as informações abaixo para o seu primeiro acesso:

**E-mail:** {{ $userEmail }}
**Senha Provisória:** {{ $provisionalPassword }}

Você deve alterar sua senha após o primeiro login.

{{ config('app.name') }}
@endcomponent
