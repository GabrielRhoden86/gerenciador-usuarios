FROM php:8.2-fpm-alpine

# Cria usuário www-data (caso não exista no Alpine)
RUN adduser -D -g '' www-data

# Instala dependências do sistema
RUN apk add --no-cache \
    nginx \
    supervisor \
    openssl \
    curl \
    curl-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    imagemagick \
    imagemagick-dev \
    sqlite-dev \
    mysql-client \
    postgresql-dev \
    dos2unix

# Instala extensões do PHP
RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql pdo_sqlite \
    curl \
    mbstring \
    xml \
    zip \
    gd

# Cria e ajusta permissões para nginx/php-fpm
RUN mkdir -p /var/lib/nginx /var/log/nginx /var/lib/nginx/tmp/client_body /run/php-fpm \
 && chown -R www-data:www-data /var/lib/nginx /var/log/nginx /run/php-fpm \
 && chmod -R 755 /var/lib/nginx /var/log/nginx /run/php-fpm

# Copia o Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia projeto
COPY . .

# Copia configs do supervisor e nginx
COPY supervisord.conf /etc/supervisord.conf
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copia o entrypoint para binários do container
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Ajusta permissões do entrypoint (garante formato UNIX também)
RUN dos2unix /usr/local/bin/docker-entrypoint.sh \
 && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

# Comando de entrada
CMD ["docker-entrypoint.sh"]
