⚙️ Configuração do Ambiente Local

```bash
1️⃣ Clone o repositório

git clone https://github.com/GabrielRhoden86/gerenciador-usuarios
2️⃣ Instale as dependências

composer install
3️⃣ Copie o arquivo .env de exemplo

cp .env.example .env
4️⃣ Gere a chave da aplicação

php artisan key:generate

5️⃣ Crie o banco de dados

CREATE DATABASE gerenciador_usuarios;
📦 Configuração do .env

🔧 Banco de Dados
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestao_alunos
DB_USERNAME=root
DB_PASSWORD=

📧 Servidor de Email (Gmail para testes)
env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gabrielrhodden@gmail.com
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gabrielrhodden@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

🚀 Inicialização da Aplicação

✅ Execute as migrações
php artisan migrate

✅ Inicie o servidor
php artisan serve

✅ Gere a chave JWT
php artisan jwt:secret

Copie a chave gerada e insira no .env:
env
JWT_SECRET=chave_gerada_aqui

✅ Otimize a aplicação

php artisan optimize

✅ Criar usuarios teste:
php artisan tinker 
for ($i = 1; $i <= 30; $i++) {
    User::create([
        'name' => "Usuario$i",
        'email' => "usuario$i@exemplo.com",
        'password' => Hash::make('senha123'), // Senha padrão
        'role_id' => 2,
    ]);
}


http://localhost:8000/api/login
👤 A
json
{
  "email": "admin@exemplo.com",
  "password": "senha123"
}

🔐 Autorização com JWT
Após o login, insira o token JWT no cabeçalho das requisições:

Authorization

✅ Requisitos
PHP >= 8.2

Laravel 12.x

MySQL 10.4.32-MariaDB

Composer 2.8.4
