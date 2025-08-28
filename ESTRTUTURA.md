# Gerenciador de Usuários - Projeto Laravel

Este projeto é um sistema de gerenciamento de usuários desenvolvido em **Laravel**, utilizando **JWT** para autenticação, middleware para proteção de rotas e o padrão **Repository-Service-Controller** para organização do código.

---

## 🔹 Estrutura do Projeto

O projeto segue a arquitetura **Repository-Service-Controller**, separando responsabilidades de forma clara:

- **Controller**: recebe as requisições HTTP, valida os dados e chama os serviços correspondentes.
- **Service**: contém a lógica de negócio do sistema, processa dados e interage com os repositórios.
- **Repository**: faz a comunicação direta com o banco de dados (queries, Eloquent, etc).

Exemplo de organização de pastas:

app/
├─ Http/
│ ├─ Controllers/
│ │ ├─ AuthController.php
│ │ └─ UsuarioController.php
├─ Services/
│ └─ UsuarioService.php
├─ Repositories/
│ └─ UsuarioRepository.php

---

## 🔹 Segurança

O sistema utiliza **JWT (JSON Web Tokens)** para autenticação:

- Ao fazer login (`POST /login`), o usuário recebe um token JWT.
- Esse token deve ser enviado no header `Authorization: Bearer <token>` para acessar rotas protegidas.
- O middleware `auth:api` protege todas as rotas de usuários.

---

## 🔹 Rotas do Projeto

### Rotas Públicas

| Método | URL                         | Descrição               |
|--------|----------------------------|------------------------|
| POST   | /login                     | Faz login no sistema   |

Exemplo de acesso via ngrok:  
https://d60b4f01eac0.ngrok-free.app/login


---

### Rotas Protegidas (JWT + Middleware)

Todas essas rotas estão dentro do middleware `auth:api`:

| Método  | URL                          | Descrição                    |
|---------|-----------------------------|-------------------------------|
| POST    | /usuarios/cadastrar          | Cadastrar novo usuário       |
| PATCH   | /usuarios/editar/{id}        | Editar usuário existente     |
| GET     | /usuarios/listar             | Listar todos os usuários     |
| DELETE  | /usuarios/excluir/{id}       | Excluir usuário             |
| GET     | /usuarios/buscar/{id}        | Buscar usuário por ID       |
| POST    | /logout                      | Encerrar sessão do usuário  |

Exemplo de acesso via ngrok:  
https://d60b4f01eac0.ngrok-free.app/usuarios/listar


---

## 🔹 Middleware

O middleware `auth:api` garante que apenas usuários autenticados podem acessar as rotas protegidas.  
Ele verifica o **JWT** enviado no header da requisição.

Exemplo:

```php
Route::middleware(['auth:api'])->prefix('usuarios')
    ->group(function () {
        Route::post('/cadastrar', [UsuarioController::class, 'cadastrarUsuario']);
        Route::patch('/editar/{id}', [UsuarioController::class, 'editarUsuario']);
        Route::get('/listar', [UsuarioController::class, 'listarUsuarios']);
        Route::delete('/excluir/{id}', [UsuarioController::class, 'excluirUsuario']);
        Route::get('/buscar/{id}', [UsuarioController::class, 'buscarUsuario']);
    });
### 🔹 Padrão Repository-Service-Controller

- **Controller**: Recebe requisições e envia respostas HTTP.  
- **Service**: Contém regras de negócio, valida dados e processa lógica.  
- **Repository**: Interage com o banco de dados.  

**Exemplo de fluxo:**  

1. `UsuarioController@cadastrarUsuario` recebe a requisição.  
2. Chama `UsuarioService@cadastrar`.  
3. `UsuarioService` usa `UsuarioRepository` para salvar no banco.  
4. Retorna resposta HTTP ao frontend.  

---

# 📌 API Gerenciador de Usuários

Durante o desenvolvimento, você pode acessar o sistema remotamente:

- **Login:** [https://gerenciador-usuarios.onrender.com/api/login](https://gerenciador-usuarios.onrender.com/api/login)  
- **Listar usuários:** [https://gerenciador-usuarios.onrender.com/api/usuarios/listar](https://gerenciador-usuarios.onrender.com/api/usuarios/listar)  
- **Cadastrar usuário:** [https://gerenciador-usuarios.onrender.com/api/usuarios/cadastrar](https://gerenciador-usuarios.onrender.com/api/usuarios/cadastrar)  
- **Editar usuário:** [https://gerenciador-usuarios.onrender.com/api/usuarios/editar/{id}](https://gerenciador-usuarios.onrender.com/api/usuarios/editar/1)  
- **Excluir usuário:** [https://gerenciador-usuarios.onrender.com/api/usuarios/excluir/{id}](https://gerenciador-usuarios.onrender.com/api/usuarios/excluir/3)  
- **Buscar usuário por ID:** [https://gerenciador-usuarios.onrender.com/api/usuarios/buscar/{id}](https://gerenciador-usuarios.onrender.com/api/usuarios/buscar/1)  
- **Logout:** [https://gerenciador-usuarios.onrender.com/api/logout](https://gerenciador-usuarios.onrender.com/api/logout)  


> Lembre-se de enviar o **JWT** no header `Authorization` para rotas protegidas.


### 🔹 Por que escolhemos o padrão Repository-Service-Controller?

O padrão **Repository-Service-Controller (RSC)** foi escolhido para organizar melhor o código, separar responsabilidades e facilitar a manutenção do sistema:

- **Controller:** Responsável por receber requisições HTTP, validar dados básicos e retornar respostas ao cliente. Mantém o código limpo, sem lógica de negócio complexa.  
- **Service:** Contém toda a lógica de negócio, regras de validação mais complexas e processamento de dados. Facilita testes unitários e reutilização da lógica em diferentes partes do sistema.  
- **Repository:** Abstrai o acesso ao banco de dados, centralizando queries e operações de persistência. Isso permite trocar facilmente o banco ou otimizar queries sem impactar a camada de serviço.

💡 **Benefícios do RSC:**
- Código mais organizado e fácil de manter.  
- Reduz duplicação de lógica de negócio.  
- Facilita testes unitários e integração.  
- Mantém a separação clara entre lógica de apresentação, negócio e persistência.

---

### 🔹 Por que  JWT (JSON Web Token)?

O JWT foi escolhido para autenticação por ser seguro, escalável e compatível com APIs RESTful:

- **Autenticação stateless:** Não precisa armazenar sessões no servidor; o token carrega as informações do usuário.  
- **Segurança:** O token é assinado digitalmente, evitando alterações maliciosas.  
- **Escalabilidade:** Ideal para sistemas distribuídos e APIs que podem ser consumidas por diferentes clientes (web, mobile, etc).  
- **Controle de acesso:** Pode incluir informações sobre permissões/roles dentro do payload, facilitando a autorização via middleware.

💡 **Benefícios do JWT:**
- Tokens fáceis de enviar no header `Authorization`.  
- Sem necessidade de armazenamento de sessão no servidor.  
- Permite expiração automática e renovação de tokens.  
- Compatível com middleware de autenticação em Laravel (`auth:api`).  
