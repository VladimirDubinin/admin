## Admin

Кастомная панель администрирования с возможностью создавать масштабируемые формы добавления и редактирования элементов.

Новая форма должна наследоваться от класса app/Forms/AbstractForm и реализовать метод form(), в котором задаётся массив полей и их свойств,
и метод getFieldsDefinition(), в котором задается связь полей из массива с названиями полей в БД.
(пример modules/Users/Forms/UserForm)

На frontend заданные в массиве поля выведутся автоматически благодаря компоненту FormComponent, реализованном на Vue 3.
(пример resources/js/views/Users/UsersComponent)

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

