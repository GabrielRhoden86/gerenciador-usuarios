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
    postgresql-dev \
    dos2unix

RUN docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql pdo_sqlite \
    curl \
    mbstring \
    xml \
    zip \
    gd



RUN mkdir -p /var/lib/nginx /var/log/nginx /var/lib/nginx/tmp/client_body /run/php-fpm && \
    chown -R www-data:www-data /var/lib/nginx /var/log/nginx /run/php-fpm && \
    chmod -R 755 /var/lib/nginx /var/log/nginx /run/php-fpm

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
RUN sed -i 's|^listen = .*|listen = /run/php-fpm/php-fpm.sock|' /usr/local/etc/php-fpm.d/www.conf

COPY . .

COPY supervisord.conf /etc/supervisord.conf
COPY nginx.conf /etc/nginx/http.d/default.conf

ENV SKIP_MIGRATIONS=true
RUN chmod +x docker-entrypoint.sh

ENV PORT=$PORT
EXPOSE $PORT

CMD ["./docker-entrypoint.sh"]
