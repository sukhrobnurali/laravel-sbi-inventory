# Laravel SBI Inventory

![Laravel](https://img.shields.io/badge/Laravel-12.x-red) ![PHP](https://img.shields.io/badge/PHP-^8.2-blue) ![Tests](https://img.shields.io/badge/tests-coverage-green)

> **Простой модуль учёта товаров** на Laravel с REST API, строгой валидацией, чистой архитектурой (Repository & Service паттерны), unit‑тестами и экспортом данных в Excel через очередь.

---

## 📦 Установка

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/sukhrobnurali/laravel-sbi-inventory.git
   cd laravel-sbi-inventory
   ```
2. Установите зависимости:
   ```bash
   composer install
   ```
3. Скопируйте пример окружения и сгенерируйте ключ:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Настройте параметры подключения к базе данных и драйвер очереди в файле `.env`.

---

## 🔧 Инициализация данных

1. Запустите миграции:
   ```bash
   php artisan migrate
   ```
2. Запустите сидеры для наполнения тестовых данных:
   ```bash
   php artisan db:seed
   ```
3. Создайте символьную ссылку для публичного доступа к файлам:
   ```bash
   php artisan storage:link
   ```

---

## 🚀 Запуск приложения

1. Запустите встроенный сервер Laravel:
   ```bash
   php artisan serve
   ```
2. Запустите обработчик очередей в другом терминале:
   ```bash
   php artisan queue:work
   ```

---

## 🛠 API Endpoints

| Метод | Маршрут                   | Описание                  |
|-------|---------------------------|---------------------------|
| GET   | `/api/categories`         | Список категорий          |
| POST  | `/api/categories`         | Создать категорию         |
| GET   | `/api/categories/{id}`    | Показать категорию        |
| PUT   | `/api/categories/{id}`    | Обновить категорию        |
| DELETE| `/api/categories/{id}`    | Удалить категорию         |
| GET   | `/api/products`           | Список товаров            |
| POST  | `/api/products`           | Создать товар             |
| GET   | `/api/products/{id}`      | Показать товар            |
| PUT   | `/api/products/{id}`      | Обновить товар            |
| DELETE| `/api/products/{id}`      | Удалить товар             |

---

## 📥 Экспорт данных в Excel

Для экспорта списка товаров в Excel через очередь выполните команду:
```bash
php artisan products:export
```

После удачной обработки очереди (`php artisan queue:work`) файл будет сохранён как:
```
storage/app/public/products.xlsx
```

---

## 🧪 Тестирование

Запустить unit‑тесты:
```bash
php artisan test
```

---

## 📖 Лицензия

MIT © Sukhrob Nuraliev

