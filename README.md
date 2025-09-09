## ⚙️ Configuração do Ambiente Local

```bash
API Gerencidor de usuários:
```

1️⃣ Clone o repositório
```bash
git clone https://github.com/GabrielRhoden86/gerenciador-usuarios`
```

2️⃣ Instale as dependências
```bash
composer install
```

3️⃣ Copie o arquivo .env de exemplo
```bash
cp .env.example .env
```

4️⃣ Gere a chave da aplicação
```bash
php artisan key:generate
```

5️⃣ Crie o banco de dados
```bash
CREATE DATABASE gerenciador_usuarios;
```

## 📦 Configuração do .env

```bash
🔧 Banco de Dados

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestao_alunos
DB_USERNAME=root
DB_PASSWORD=
```

📧 Servidor de Email (Gmail para testes)
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gabrielrhodden@gmail.com
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gabrielrhodden@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
🚀 Inicialização da Aplicação
✅ Execute as migrações
```bash
php artisan migrate
```

✅ Inicie o servidor
```bash
php artisan serve
```

✅ Gere a chave JWT
```bash
php artisan jwt:secret
```

Copie a chave gerada e insira no .env:
```bash
JWT_SECRET=chave_gerada_aqui
```

✅ Otimize a aplicação
```bash
php artisan optimize
```
## 📌 API Gerenciador de Usuários

## 🔑 Autenticação

### Login
**Endpoint:**  
`POST http://localhost:8000/api/login`

**Body (JSON):**
```bash
{
  "email": "admin@exemplo.com",
  "password": "senha123"
}
```
**Cadastrar Usuário**
POST https://gerenciador-usuarios.onrender.com/api/usuarios/cadastrar
```bash
{
  "nome": "João da Silva",
  "email": "joao@exemplo.com",
  "password": "senha123"
}
```
**Editar Usuário**
PATCH https://gerenciador-usuarios.onrender.com/api/usuarios/editar/{id}
```bash
{
  "nome": "João Atualizado",
  "email": "joao@novoemail.com"
}
```
**Deletar usuário**
DELETE https://gerenciador-usuarios.onrender.com/api/usuarios/excluir/{id}

🚪 Logout
Endpoint:
POST http://localhost:8000/api/logout

✅ Requisitos
PHP >= 8.2

Laravel 12.x

MySQL 10.4.32-MariaDB

Composer 2.8.4
