Чтобы развернуть приложение на локальном сервере:

1. Клонировать репозиторий `git clone https://github.com/borashek32/republic.git`
2. `composer install`
3. `npm install`
4. `npm run watch`
5. Переименовать `.env.example` в `.env`, отредактировать файл в соответствии с вашими настройками сервера и бд (у меня MAMP pro, создаю хост на сервере и бд в PhpMyAdmin ручками и заполяю `.env`, для MacOs нужно прописать сокет `DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock`)
6. `php artisan migrate --seed` (бд нужно сидить, потому что так создаются роли и админ)
7. `php artisan storage:link`
8. Запустить приложение `php artisan serv`
9. Данные для входа админа: `admin@gmail.com`, пароль `11111111`
   Данные для входа юзера: `user@gmail.com`, пароль `22222222`
10. Для теста уведомлений об активации аккаунта используется сервис mailhog, если он не установлен,то его следует установить, инструкции по ссылке https://github.com/mailhog/MailHog. В `.env` исправить строчку `MAIL_HOST=mailhog` на `MAIL_HOST=localhost`. В браузере перейти по http://127.0.0.1:8025/ для доступа к UI
11. Для тестов `php artisan test`
