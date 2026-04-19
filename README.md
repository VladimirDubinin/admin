## Admin

Шаблон кастомной панели администрирования сайта на Laravel.
Для frontend используется Vue 3.
Панель администрирования позволяет создавать легко масштабируемые формы благодаря классу AbstractForm и
набору Input-классов на backend, и form-component на frontend, который автоматически отобразит массив полей.

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

