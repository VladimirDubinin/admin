## Admin

Кастомная панель администрирования сайта Laravel.
Frontend реализован на Vue 3.

## Порядок установки

```bash
git clone git@github.com:VladimirDubinin/admin.git {PROJECT_NAME}.loc
```

```bash
cd {PROJECT_NAME}.loc
```

```bash
composer install
```

Копировать .env файл и изменить настройки подключения к БД

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

## Установка в докере

Если нет make, то взять команды из makefile и выполнять напрямую

Создание контейнера.

```bash
make build
```

Запуск контейнера.

```bash
make up
```

Открыть консоль:

```
make shell
```

В консоли уже можно продолжить обычную установку с шага composer install

