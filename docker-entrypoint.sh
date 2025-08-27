#!/bin/sh

# Instala as dependências do Composer.
composer install --no-dev --optimize-autoloader

# Concede permissões de escrita para as pastas de armazenamento e cache.
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Executa as migrações do banco de dados.
php artisan migrate --force

# Limpa o cache.
php artisan cache:clear
php artisan optimize:clear

# Inicia o servidor do Laravel usando a variável de ambiente PORT do Railway.
php artisan serve --host=0.0.0.0 --port=${PORT}
