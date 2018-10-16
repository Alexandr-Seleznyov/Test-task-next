##### Laravel 5.4
##### MySQL 5.6
##### PHP 7.1
Выполнены все пункты задания.

git clone https://github.com/Alexandr-Seleznyov/Test-task-next.git

composer install

Создаём базу данных с именем и пользователем, указанными в файле .env

php artisan migrate:refresh --seed

(10 - 20 сек.)


Вход: (по умолчанию)

user: admin@admin.com

pass: 1234



Регистрация требует подтверждения электронной почты. Мои smtp настройки (в .env) работают, но в случае нового места (ip) подключения, gmail может заблокировать.

Diagram.mwb - Структура БД.
