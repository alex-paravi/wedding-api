# 💒 Wedding Guest List & Table Management API

RESTful API сервис для управления списками гостей, их рассадкой за столами и подтверждением присутствия на свадьбе. Проект разработан в рамках перехода на уровень Junior+ PHP/Laravel Developer с упором на чистую архитектуру, безопасность, оптимизацию работы с базой данных и автотестирование.

---

## 🚀 Технологический стек

- Язык: PHP 8.3
- Фреймворк: Laravel 11.x (REST API)
- База данных: MySQL / SQLite
- Аутентификация: Laravel Sanctum (токены)
- Тестирование: Pest PHP / PHPUnit
- Архитектурные паттерны: API Resources (трансформеры данных), Eager Loading, Form Requests, Custom Policies, Composite Indexing.

---

## 🛠 Архитектурные особенности и оптимизация

- Оптимизация производительности (Борьба с N+1): В GuestController и GuestResource реализована подгрузка отношений через Eager Loading (with(['table', 'user'])) и условная загрузка в ресурсах через $this->whenLoaded(). Это гарантирует сокращение количества SQL-запросов с десятков до 2 фиксированных.
- Индексация базы данных: На таблице guests создан составной индекс (Composite Index) ['user_id', 'status', 'side'], спроектированный с учетом принципа левого префикса (Leftmost Prefix Rule) для мгновенной фильтрации.
- SQL-аналитика и агрегации: Написаны оптимизированные запросы с использованием JOIN, GROUP BY и HAVING для расчета заполняемости и статистики столов.
- Безопасность и изоляция данных: Все ресурсы защищены мидлваром auth:sanctum и политиками доступа (GuestPolicy). Пользователь-организатор имеет доступ исключительно к своим гостям и столам (обработка 403 Forbidden).
- Автотесты (Feature Tests): Написано покрытие ключевых сценариев API с использованием Pest PHP (RefreshDatabase, эмуляция авторизации через actingAs(), проверки валидации 422, прав доступа 403 и состояния базы данных assertDatabaseHas).

---

## 📋 Реализованный функционал API

### 🔑 Авторизация (/api)

- POST /api/register — Регистрация пользователя.
- POST /api/login — Вход и получение токена доступа Sanctum.

### 👥 Управление гостями (/api/guests)

- GET /api/guests — Получение списка гостей пользователя с фильтрацией (например, ?side=bride&status=confirmed) и устранением N+1.
- GET /api/guests/{id} — Просмотр карточки конкретного гостя.
- POST /api/guests — Добавление гостя с валидацией через FormRequest.
- PATCH /api/guests/{id} — Обновление данных гостя (привязка к столу, статус, сторона).
- DELETE /api/guests/{id} — Удаление гостя из системы.

### 🍽 Управление столами & Статистика (/api/tables)

- Route::apiResource('tables', TableController::class) — Полный CRUD для столов.
- GET /api/tables/stats — Статистика по рассадке и переполненности столов (агрегационные SQL-запросы).

---

## 🧪 Запуск автотестов

В проекте настроены и пройдены Feature-тесты, проверяющие статус-коды (201, 401, 403, 422), валидацию и физическую запись в БД.

Для запуска всех тестов выполните:
php artisan test

---

## 💻 Как запустить проект локально

1. Клонировать репозиторий:
   git clone [https://github.com/alex-paravi/wedding-api.git](https://github.com/alex-paravi/wedding-api.git)
   cd wedding-api

2. Установить зависимости Composer:
   composer install

3. Настроить файл окружения:
   cp .env.example .env
   php artisan key:generate

4. Запустить миграции и сиды:
   php artisan migrate --seed

5. Запустить локальный сервер:
   php artisan serve
   (API будет доступно по адресу: [http://127.0.0.1:8000](http://127.0.0.1:8000))

---

## 🎯 Тестирование API (Postman)

В корне репозитория приложен файл коллекции Postman: Wedding Guest List API.postman_collection.json.

1. Импортируйте этот файл в Postman.
2. Убедитесь, что локальный сервер запущен (php artisan serve).
3. Выполните запрос POST /api/login, скопируйте полученный токен и укажите его в Bearer Token для защищенных эндпоинтов.
