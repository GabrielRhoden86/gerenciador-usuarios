#!/bin/sh

# Converte o arquivo para o formato LF (Linux) para evitar erros no Docker
# Este comando é útil para garantir a compatibilidade, especialmente se o arquivo
# foi criado em um sistema Windows.
if command -v dos2unix >/dev/null 2>&1; then
    dos2unix "$0"
fi

# Instala as dependências do Composer com as opções de otimização
echo "Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader

# Concede as permissões de escrita necessárias para o Laravel
echo "Concedendo permissões para as pastas 'storage' e 'bootstrap/cache'..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Executa as migrações do banco de dados em produção
echo "Executando migrações do banco de dados..."
php artisan migrate --force

# Limpa os caches da aplicação
echo "Limpando caches do Laravel..."
php artisan cache:clear
php artisan optimize:clear

# Inicia o Supervisor para gerenciar o Nginx e o PHP-FPM
# O comando 'exec' garante que o Supervisor substitua o processo atual do shell
echo "Iniciando Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
