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

# Copia o entrypoint primeiro
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Dá permissão de execução ao entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www/html

# Copia o restante do código
COPY . .

EXPOSE 8000

# O Dockerfile agora executa o script que inicia o Supervisor
CMD ["sh", "/usr/local/bin/docker-entrypoint.sh"]
