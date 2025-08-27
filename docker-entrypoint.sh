#!/bin/sh

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

composer install --no-dev --optimize-autoloader

php artisan migrate --force

php artisan cache:clear
php artisan optimize:clear

php artisan serve --host=0.0.0.0 --port=8000
