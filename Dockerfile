FROM php:8.2-fpm-alpine

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
    postgresql-dev

RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql pdo_sqlite \
    curl \
    mbstring \
    xml \
    zip \
    gd

# Copia o Composer para o contêiner
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Copia a configuração do Supervisor
COPY supervisord.conf /etc/supervisord.conf

# Adiciona permissão de execução ao script
RUN chmod +x docker-entrypoint.sh

WORKDIR /var/www/html

COPY . .

EXPOSE 8000

# O Dockerfile agora executa o script que inicia o Supervisor
CMD ["sh", "docker-entrypoint.sh"]
