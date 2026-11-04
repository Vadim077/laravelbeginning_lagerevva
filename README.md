# Laravel: Начало 

Веб-приложение на базе фреймворка Laravel

## Реализованный функционал

1. **Инициализация проекта**:
   - Проект развернут через Composer на базе Laravel.
   - Заданы базовые настройки в `.env`: сгенерирован секретный ключ (`APP_KEY`), задана локаль (`APP_LOCALE=ru`), часовой пояс (`APP_TIMEZONE=Europe/Moscow`) и режим отладки (`APP_DEBUG=true`).

2. **Маршрутизация и Контроллеры**:
   - `GET /` — отображение страницы с формой обратной связи (`FormController@showForm`).
   - `POST /submit` — приём данных формы, серверная валидация и сохранение (`FormController@submitForm`).
   - `GET /submissions` — отображение страницы со списком всех полученных заявок (`FormController@showSubmissions`).

3. **Серверная валидация и сохранение**:
   - Серверная валидация полей: `name` (обязательно, от 2 символов), `email` (валидный email), `message` (обязательно, от 5 символов).
   - Вывод сообщений об ошибках при некорректном заполнении.
   - Сохранение каждой успешной заявки в отдельный файл `storage/app/submissions/submission_{uniqid}_{time}.json`.
   - Вывод уведомления об успешном сохранении с именем созданного файла.

4. **Просмотр данных**:
   - На странице `/submissions` реализовано динамическое чтение всех JSON-файлов и отображение в виде таблицы.

---

## Скриншоты работы приложения

### 1. Страница формы (GET `/`)
<img width="1920" height="922" alt="laravel1" src="https://github.com/user-attachments/assets/bfaaaf3e-610d-4628-a554-43f8441f09fb" />


### 2. Валидация формы и вывод ошибок
<img width="1099" height="785" alt="image" src="https://github.com/user-attachments/assets/bea157da-c222-4337-beb4-6225a08927b6" />

### 3. Успешная отправка и сохранение в JSON
<img width="1080" height="675" alt="image" src="https://github.com/user-attachments/assets/b2c6b62b-b2ed-459a-8951-424f1a212d51" />


### 4. Таблица всех полученных заявок (GET `/submissions`)
<img width="1123" height="440" alt="image" src="https://github.com/user-attachments/assets/65f69822-9e33-4d20-aff3-ba87768e4c9e" />


---

## Запуск проекта локально

1. Клонировать репозиторий:
   ```bash
   git clone https://github.com/Vadim077/laravelbeginning_lagerevva.git
   cd laravelbeginning_lagerevva
   ```

2. Установить зависимости:
   ```bash
   composer install
   ```

3. Настроить окружение:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Запустить миграции (для сессий/кэша):
   ```bash
   php artisan migrate
   ```

5. Запустить сервер:
   ```bash
   php artisan serve
   ```
   Приложение будет доступно по адресу: [http://127.0.0.1:8000](http://127.0.0.1:8000)
