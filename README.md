# 🎬 PPW2 — Sistema de Filmes

Projeto acadêmico desenvolvido para a disciplina de PPW2, utilizando **PHP Laravel**, **Docker** e **PostgreSQL**.

---

## 📋 Requisitos

Antes de começar, você precisa ter instalado na sua máquina:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)

---

## 🚀 Como rodar o projeto

### 1. Clone o repositório

```bash
git clone https://github.com/Rafaelmjmj/PPW2.git
cd PPW2
```

### 2. Configure o ambiente

```bash
cp .env.example .env
```

### 3. Suba os containers

```bash
docker compose up -d
```

> Aguarde o Docker baixar as imagens e iniciar os containers. Pode levar alguns minutos na primeira vez.

### 4. Gere a chave da aplicação

```bash
docker compose exec php php artisan key:generate
```

### 5. Rode as migrations

```bash
docker compose exec php php artisan migrate
```

---

## 🌐 Acessos

| Serviço | URL | Descrição |
|---|---|---|
| Aplicação | http://localhost:8080 | Sistema Laravel |
| pgAdmin | http://localhost:5050 | Interface do banco de dados |

---

## 🗄️ Acessando o banco de dados (pgAdmin)

Acesse `http://localhost:5050` e logue com:

| Campo | Valor |
|---|---|
| Email | `admin@admin.com` |
| Senha | `admin` |

Depois registre o servidor com:

- **Host:** `postgres`
- **Port:** `5432`
- **Database:** `laravel`
- **Username:** `laravel`
- **Password:** `secret`

---

## 🐳 Serviços Docker

| Serviço | Imagem | Porta |
|---|---|---|
| nginx | nginx:alpine | 8080 |
| php | custom (php:8.2-fpm) | — |
| postgres | postgres:16-alpine | 5433 |
| pgadmin | dpage/pgadmin4 | 5050 |

---

## 🗂️ Estrutura do projeto

```
PPW2/
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   └── php/
│       └── Dockerfile
├── src/                  # Aplicação Laravel
│   ├── app/
│   ├── database/
│   │   └── migrations/
│   └── ...
├── .env.example
└── docker-compose.yml
```

---

## 🔄 Comandos úteis

```bash
# Subir os containers
docker compose up -d

# Derrubar os containers
docker compose down

# Ver logs
docker compose logs -f

# Rodar migrations
docker compose exec php php artisan migrate

# Resetar banco de dados
docker compose exec php php artisan migrate:fresh

# Acessar o container PHP
docker compose exec php bash
```

---

## 📦 Tecnologias utilizadas

- **Laravel 11** — Framework PHP
- **PostgreSQL 16** — Banco de dados
- **Docker & Docker Compose** — Containerização
- **Nginx** — Servidor web
- **pgAdmin 4** — Interface de administração do banco
