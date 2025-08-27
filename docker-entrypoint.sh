#!/bin/sh

# Instala as dependências do Composer
composer install --no-dev --optimize-autoloader

# Concede permissões para as pastas do Laravel
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Executa as migrações do banco de dados
php artisan migrate --force

# Limpa o cache
php artisan cache:clear
php artisan optimize:clear

# Inicia o Supervisor, que vai gerenciar o Nginx e o PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisord.conf
