#!/bin/sh
set -e

echo "📦 Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader

echo "🔑 Ajustando permissões..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "🗄️ Executando migrações..."
php artisan migrate --force || true

echo "🧹 Limpando caches do Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo "🚀 Iniciando Laravel na porta \$PORT..."
exec php -S 0.0.0.0:${PORT:-8080} -t public
