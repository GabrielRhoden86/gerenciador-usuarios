#!/bin/sh

# Instala as dependências do Composer
composer install --no-dev --optimize-autoloader

# Concede permissões para as pastas do Laravel
# Usamos 'chown' para garantir que as permissões de usuário estejam corretas
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Executa as migrações do banco de dados
php artisan migrate --force

# Limpa o cache
php artisan cache:clear
php artisan optimize:clear

# Inicia o PHP-FPM em primeiro plano
/usr/sbin/php-fpm8.2 -F

# Inicia o Nginx em primeiro plano
nginx -g "daemon off;"
