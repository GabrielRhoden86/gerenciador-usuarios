#!/bin/sh

if [ -z "$APP_KEY" ]; then
    echo "A variável de ambiente APP_KEY não está definida."
    exit 1
fi

echo "Concedendo permissões..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader

echo "Limpando o cache da aplicação..."
php artisan optimize:clear

echo "Executando migrações do banco de dados..."
php artisan migrate --force

echo "Iniciando o servidor..."
php artisan serve --host=0.0.0.0 --port=8000
