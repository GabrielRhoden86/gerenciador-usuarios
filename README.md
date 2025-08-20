# 🎓 API - Gestão de Alunos (Laravel 12)

**Sistema de gestão de alunos desenvolvido com Laravel 12.**

---

## ⚙️ Configuração do Ambiente Local para Testes

### 1️⃣ Clone o repositório

```bash
git clone https://github.com/GabrielRhoden86/gestao_alunos.git
2️⃣ Instale as dependências
 
composer install
3️⃣ Copie o arquivo .env de exemplo
 
cp .env.example .env
4️⃣ Gere a chave da aplicação
 
php artisan key:generate

## crie o banco de dados: gestao_alunos
CREATE DATABASE gestao_alunos;

📦 Variáveis de ambiente
Você deve configurar os seguintes campos no seu arquivo .env:

1️⃣ Configure o banco de dados
No arquivo .env, edite conforme necessário:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestao_alunos
DB_USERNAME=root
DB_PASSWORD=

2️⃣ Configure o servidor de email (teste Gmail) 
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gabrielrhodden@gmail.com
MAIL_PASSWORD=qntfweonctgospkg
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gabrielrhodden@gmail.com
MAIL_FROM_NAME="${APP_NAME}"


✅ Execute as migrações
php artisan migrate

✅ Inicie o servidor
 php artisan serve --port=8002

✅ Gere a chave JWT
php artisan jwt:secret
📝 Copie a chave gerada e insira no .env:
JWT_SECRET=chave_gerada_aqui

✅ Otimize a aplicação
php artisan optimize

---
❗ IMPORTANTE:
No arquivo database\seeders\DatabaseSeeder.php, substitua pelo email que irá receber a notificação:
# Perfil Gestor
    User::factory()->create([
        'email' =>  "email_para_gestao@notificacao.com",
        'perfil' => 'gestor',
    ]);

Esse email será usado tanto para notificação como para login do gestor. 
Caso queira mudar, basta alterar o email no arquivo DatabaseSeeder

✅ php artisan db:seed

```bash

🧪 Exemplos de como testar a aplicação:

🔐 Autenticação JWT
🔑 Login para obter token:
POST http://localhost:8002/api/login

👤 Acessar como Gestor
{
  "email": "email_para_gestao@notificacao.com", 
  "password": "230803"
}
👤 Acessar como Funcionário
 
{
  "email": "funcionario@email.com",
  "password": "230803"
}
🔐 Autorização com JWT
Após realizar o login com sucesso e receber o token JWT, você deve inseri-lo no cabeçalho da requisição para acessar as rotas protegidas.

✅ Exemplo no Postman
Cabeçalho HTTP (Headers):

Key         	Value
Authorization	Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...

📚 Funcionalidades da API
👨‍🎓 Cadastrar aluno
POST http://127.0.0.1:8002/api/criar-aluno
{
  "nome": "Gabriel Rhoden",
  "cpf": "12345678900",
  "data_nascimento": "1990-01-01",
  "turma": "TI-2025",
  "status": "Pendente"
}

✏️ Atualizar aluno
PATCH http://127.0.0.1:8002/api/editar-aluno/1
{
  "nome": "Gabriel Rhoden",
  "turma": "TI-2025",
  "status": "Cancelado"
}


✅ Requisitos
PHP >= 8.2

Laravel 12.x

MySQL 10.4.32-MariaDB

Composer 2.8.4

👨‍💻 Autor
Gabriel Rhoden
📧 gabrielrhdden@email.com
🔗 linkedin.com/in/gabrielrhoden86


