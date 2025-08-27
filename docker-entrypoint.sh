#!/bin/sh

# Instala as dependências do Composer.
# Essa é a primeira coisa que deve ser feita.
composer install --no-dev --optimize-autoloader

# Concede permissões de escrita para as pastas de armazenamento e cache.
# Isso deve ser feito depois das dependências, que podem criar arquivos.
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Executa as migrações do banco de dados.
# Isso garante que a tabela 'cache' e outras existam.
php artisan migrate --force

# Limpa o cache.
# Agora é seguro executar este comando.
php artisan cache:clear
php artisan optimize:clear

# Inicia o servidor do Laravel.
php artisan serve --host=0.0.0.0 --port=8000
