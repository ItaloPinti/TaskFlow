# TaskFlow

Sistema de gerenciamento de tarefas desenvolvido em PHP 8+, MySQL e arquitetura MVC.

## Funcionalidades
- Cadastro e login de usuários.
- Senhas armazenadas com `password_hash()` usando bcrypt e verificadas com `password_verify()`.
- Dashboard com indicadores e tarefas recentes.
- CRUD completo de tarefas.
- Cadastro e exclusão de categorias.
- Cada usuário acessa somente suas próprias tarefas e categorias.
- Consultas preparadas com PDO e token CSRF nos formulários.

## Design Patterns
- **Singleton:** `app/Core/Database.php` mantém uma única instância da conexão PDO durante a requisição.
- **Repository:** `app/Repositories/` concentra o acesso aos dados e separa SQL dos Controllers.

## Requisitos
- PHP 8.1+ (recomendado PHP 8.3+).
- MySQL 8+.
- Extensões PHP `pdo_mysql` e `mbstring`.

## Instalação
1. Extraia a pasta `TaskFlow` em seu computador e abra-a no VS Code.
2. No MySQL Workbench, execute todo o conteúdo de `database/database.sql`.
3. Edite `config/database.php` e informe usuário e senha do seu MySQL.
4. No terminal do VS Code, na pasta raiz do projeto, execute:

   ```bash
   php -S localhost:8000 -t public
   ```

5. Acesse http://localhost:8000
6. Crie sua conta pela tela **Criar conta**.

## Rotas principais
- `/register` — cadastro.
- `/login` — login.
- `/dashboard` — painel inicial.
- `/tasks` — listagem e CRUD de tarefas.
- `/categories` — gerenciamento de categorias.

## Observações
- O servidor embutido do PHP é adequado para desenvolvimento local, não para publicação em produção.
- Para produção, configure HTTPS, cookies de sessão seguros, proteção de configuração/segredos e um servidor web apropriado.
- A configuração inicial pressupõe que o banco MySQL esteja acessível localmente.
