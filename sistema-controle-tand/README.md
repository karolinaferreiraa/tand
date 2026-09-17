# Sistema de Controle TAND

Aplicação Laravel

## Tecnologias principais

- PHP 8.3+
- Composer
- Node.js 18+ / npm
- Laravel Framework 13
- Livewire 4
- Flux para interface
- Fortify para autenticação
- SQLite (configuração padrão do projeto)
- Vite para assets front-end

## Requisitos

Antes de iniciar, verifique se os itens abaixo estão instalados no seu ambiente:

- PHP 8.3 ou superior
- Composer
- Node.js 18 ou superior
- npm
- Git

### Verificação rápida

```bash
php -v
composer --version
node -v
npm -v
```

Se alguma dessas etapas falhar, instale a versão correspondente antes de prosseguir.

## Clonando o projeto

```bash
git clone <url-do-repositorio>
cd sistema-controle-tand
```

## Instalação das dependências

### 1) Instalar dependências PHP

```bash
composer install
```

### 2) Instalar dependências do front-end

```bash
npm install
```

## Configuração do ambiente

Crie o arquivo de ambiente a partir do exemplo:

```bash
copy .env.example .env
```

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### Gerar a chave da aplicação

```bash
php artisan key:generate
```

### Configurar banco de dados

O projeto vem com SQLite como padrão no arquivo `.env.example`:

```env
DB_CONNECTION=sqlite
```

Se quiser usar SQLite local, pode criar o arquivo do banco:

```bash
type nul > database\database.sqlite
```

No Linux/macOS:

```bash
touch database/database.sqlite
```

## Executando as migrations

```bash
php artisan migrate
```

Se quiser cadastrar dados iniciais e popular o banco, pode usar seeders conforme a estrutura do projeto.

## Compilar os assets do frontend

Para produção:

```bash
npm run build
```

Para desenvolvimento:

```bash
npm run dev
```

## Rodando o projeto

### Opção 1: ambiente de desenvolvimento padrão

```bash
php artisan serve
```

Acesse:

```text
http://localhost:8000
```

### Opção 2: usando o comando do Laravel para frontend + backend

```bash
composer run dev
```

Esse comando inicia o ambiente de desenvolvimento do Laravel, incluindo os assets e o servidor local.

## Dependências do projeto

### PHP

O projeto usa as seguintes dependências principais em `composer.json`:

- `laravel/framework`
- `livewire/livewire`
- `livewire/flux`
- `laravel/fortify`
- `laravel/chisel`
- `laravel/tinker`

### Frontend

As dependências do Node estão em `package.json`:

- `vite`
- `tailwindcss`
- `laravel-vite-plugin`
- `@laravel/passkeys`
- `concurrently`

## Scripts úteis

No `composer.json`, existem scripts prontos para ajudar no setup e manutenção:

```bash
composer run setup
```

Esse comando executa:

- `composer install`
- criação do `.env` se necessário
- `php artisan key:generate`
- `php artisan migrate`
- `npm install`
- `npm run build`

### Verificações e testes

```bash
php artisan test
```

```bash
composer run lint
```

```bash
composer run types:check
```

## Estrutura importante

- `app/` — código da aplicação
- `config/` — configurações do Laravel
- `database/migrations/` — migrations do banco
- `resources/views/` — views Blade
- `routes/` — rotas da aplicação
- `public/` — assets públicos
- `tests/` — testes automatizados

## Solução de problemas comuns

### Erro de chave de aplicação

```bash
php artisan key:generate
```

### Erro de banco não encontrado

```bash
php artisan migrate
```

Se estiver usando SQLite, confirme se o arquivo `database/database.sqlite` existe.

### Assets não carregam

```bash
npm install
npm run build
```

### Projeto não inicia

Verifique se o PHP, Composer e Node estão instalados corretamente e se o arquivo `.env` foi gerado.

## Dicas

- Mantenha o ambiente em PHP 8.3+
- Use `composer run dev` no desenvolvimento local
- Para produção, compile os assets com `npm run build`
- Sempre rode `php artisan migrate` após alterar estrutura do banco

## Observação

Este projeto já está configurado como uma base Laravel com Livewire e autenticação moderna, pronta para desenvolvimento e testes locais.
