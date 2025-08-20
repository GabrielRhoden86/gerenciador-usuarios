# Configuração 🐳 Docker

⚙️ Comandos para subir o projeto:
 
```bash
💡 Observação: pode ser necessário utilizar sudo antes dos comandos abaixo para garantir permissões.

1️⃣  Clonar o repositório do projeto
git clone https://github.com/GabrielRhoden86/gestao_alunos.git

cd gestao_alunos

2️⃣ Copiar o arquivo de ambiente
cp .env.example .env

📦 Variáveis de ambiente
Você deve configurar os seguintes campos no seu arquivo .env:

1️⃣ Configure o banco de dados
No arquivo .env, edite conforme necessário:
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=gestao_alunos
DB_USERNAME=root
DB_PASSWORD=root

2️⃣ Configure o servidor de email server com essas credencias para receber notificação 
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gabrielrhodden@gmail.com
MAIL_PASSWORD=qntfweonctgospkg
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gabrielrhodden@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

🐳 Subir os containers Docker
docker-compose up -d --build
Sobe os containers definidos no docker-compose.yml em modo destacado background, com rebuild.

3️⃣ Acessar o container da aplicação
docker exec -it gestao-alunos-app bash

Abre um terminal dentro do container Laravel para executar comandos.

4️⃣ Instalar dependências PHP com Composer
composer install
Instala as bibliotecas e dependências PHP necessárias para o projeto.

5️⃣ Gerar chave de criptografia da aplicação
php artisan key:generate
Gera a chave de segurança usada para criptografia e sessões no Laravel.

6️⃣ Gerar a chave JWT para autenticação
php artisan jwt:secret
Cria a chave usada para autenticação JWT no sistema.

9️⃣ Otimizar o framework Laravel
php artisan optimize
Gera caches para melhorar performance da aplicação.

7️⃣  Executar migrações do banco de dados
php artisan migrate
Cria as tabelas e estrutura do banco conforme as migrations do projeto.

---
❗ IMPORTANTE: Caso não tenha feito O  1° tutorial do READM.MD:
No arquivo database\seeders\DatabaseSeeder.php, substitua pelo email que irá receber a notificação:
# Perfil Gestor
    User::factory()->create([
        'email' =>  "email_para_gestao@notificacao.com",
        'perfil' => 'gestor',
    ]);

Esse email será usado tanto para notificação como para login do gestor. 
Caso queira mudar, basta alterar o email no arquivo DatabaseSeeder

```bash

8️⃣ Insere os usuarios funcionário e gestor no banco de dados
php artisan db:seed
Insere dados de exemplo ou obrigatórios no banco para o sistema funcionar.


9️⃣ http://localhost:8002/api/login
Acessa a rota de login para obter token de autenticação.


POST http://localhost:8002/api/login

👤 Acessar como Gestor  (use o email que você alterou em 'seeders\DatabaseSeeder.php' )
{
  "email": "email_para_gestao@notificacao.com", 
  "password": "230803"
}
👤 Acessar como Funcionário
 
{
  "email": "funcionario@email.com",
  "password": "230803"
}
