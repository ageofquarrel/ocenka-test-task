# 🎯 Ocenka Test Task

---

## ⚙️ Установка

```bash
# 1. Клонировать репозиторий
git clone https://github.com/ageofquarrel/ocenka-test-task.git

# 2. Перейти в директорию и скопировать переменные окружения
cd ocenka-test-task
cp .env.example .env

# 3. Собрать и запустить контейнеры
docker-compose up -d --build

# 4. Войти в контейнер приложения
docker exec -it symfony_app bash

# 5. Установить зависимости
composer install

# 6. Создать базу, выполнить миграции и загрузить фикстуры
php bin/console doctrine:database:create
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## ✅ Запуск тестов

```bash
# 1. Войти в контейнер базы данных
docker exec -it symfony_db bash

# 2. Настроить тестовую БД
mysql -u root -p

В MySQL:

CREATE USER 'default'@'localhost' IDENTIFIED BY 'secret';
CREATE DATABASE estimate_test;
GRANT ALL PRIVILEGES ON estimate_test.* TO 'default'@'%';
exit;

# 3. Выйти из БД и снова войти в контейнер приложения
exit
docker exec -it symfony_app bash

# 4. Запустить тесты контроллера
./vendor/bin/phpunit --group=EstimateController
```

## 🌍 Фронт

```bash
🔗 Стартовая страница: http://localhost:8000/dashboard

👤 Данные тестового пользователя

📧 Email: test@example.com
🔑 Пароль: 123456
```

