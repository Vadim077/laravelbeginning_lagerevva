# Веб-приложение на Laravel

Учебный проект на фреймворке Laravel, реализующий работу с формами, сохранением в JSON, а также работу с базой данных через Eloquent ORM.

## Функционал приложения

### 1. Работа с базой данных (Eloquent ORM)
- **Модели и миграции**: `Category`, `Tag`, `Post`, `Comment`, таблица связей `post_tag`.
- **Связи между моделями**:
  - `BelongsTo` (Post -> Category, Post -> User)
  - `HasMany` (Category -> Posts, User -> Posts)
  - `BelongsToMany` (Post <-> Tag)
  - Полиморфная связь `MorphMany` / `MorphTo` (Post -> Comments, Comment -> Commentable)
- **Query Scopes**: фильтрация постов (`published`, `popular`, `byCategory`).
- **Мягкое удаление (Soft Deletes)**: удаленные посты помечаются датой в `deleted_at`.
- **CRUD**: просмотр списка, создание, просмотр, редактирование и удаление публикаций (`/posts`).
- **API**: контроллер с ответом в формате JSON через API Resources (`/api/posts`).

### 2. Форма и сохранение данных в JSON
- Форма обратной связи с серверной валидацией (`/`).
- Сохранение полученных заявок в формате JSON с уникальным именем файла в `storage/app/submissions/`.
- Страница со списком всех полученных заявок в виде таблицы (`/submissions`).

---

## Запуск проекта

1. Установка зависимостей:
   ```bash
   composer install
   ```
2. Настройка окружения:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Применение миграций и сидеров:
   ```bash
   php artisan migrate --seed
   ```
4. Запуск сервера:
   ```bash
   php artisan serve
   ```
   Приложение доступно по адресу: `http://127.0.0.1:8000`

   <img width="1179" height="570" alt="image" src="https://github.com/user-attachments/assets/6fb240aa-f755-494f-a5d0-021e843d287b" />

   <img width="1212" height="750" alt="image" src="https://github.com/user-attachments/assets/3a351764-766b-4cde-948e-1d8fe8f0a27c" />


