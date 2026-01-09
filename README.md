# Balance Management API

#### Простое API приложение для управления задачами.

# Требования
- [Docker](https://docs.docker.com/engine/install/)
- [Docker Compose](https://docs.docker.com/compose/install/#install-compose)

# Как запустить

### Первый запуск
- `git clone https://github.com/Kinasai/test-tasks.git`
- `cd test-tasks`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `composer update`
- `cp .env.example .env && php artisan key:generate && php artisan storage:link`
- `php artisan migrate && php artisan db:seed`

### Последующий запуск
- `docker compose up -d`

# API Endpoints
### 1. Вывод списка задач с пагинацией

#### GET /api/tasks

### 2. Вывод задачи по {id}

#### GET /api/tasks/{id}

### 3. Создание задачи

#### POST /api/tasks

- `{
"title": string,
"description": string,
}`
### 4. Изменение задачи

#### PUT /api/tasks/{id}

- `{
"title": string,
"description": string,
"status": enum [new, in_progress, in_review, completed, cancelled],
}`

### 5. Удаление задачи

#### DELETE /api/tasks/{id}

Структура базы данных

    tasks - таблица задач
