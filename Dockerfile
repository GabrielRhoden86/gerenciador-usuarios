FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    openssl \
    libpng \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    imagemagick \
    imagemagick-dev \
    sqlite-dev \
    mysql-client \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

EXPOSE 8000

CMD ["sh", "docker-entrypoint.sh"]
