Інструкція що до розгортання проекту на Laravel 10

Перш за все, переконайтеся, що на вашому комп'ютері встановлений веб-сервер та СУБД MySQL, а також PHP версії 8.1 або вище та Composer.

Завантажте Laravel за допомогою Composer командою: composer create-project --prefer-dist laravel/laravel DirectoryBookCRUD. 
Створіть базу даних для вашого проекту у СУБД та налаштуйте доступ до неї у файлі .env.
Виконайте міграції командою: php artisan migrate, щоб створити необхідні таблиці у базі даних.
Виконайте автоматичне додавання данних на сервер командами:
php artisan db:seed --class=BookSeeder
php artisan db:seed --class=AuthorSeeder
Для того щоб запрацював каталог файлів введіть таку команду:
php artisan storage:link
Запустіть локальний сервер командою: php artisan serve.
Перейдіть до вашого веб-браузера та відкрийте сторінку http://localhost:8000 для перевірки роботи проекту!
