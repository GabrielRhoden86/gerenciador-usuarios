FROM php:8.2-fpm

# dependências
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    locales \
    jpegoptim optipng pngquant gifsicle \
 && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* \
 && mkdir -p /var/www/gestao_alunos/storage/framework/views \
    /var/www/gestao_alunos/storage/framework/sessions \
    /var/www/gestao_alunos/storage/framework/cache/data \
    /var/www/gestao_alunos/storage/logs \
    /var/www/gestao_alunos/bootstrap/cache \
 && touch /var/www/gestao_alunos/storage/logs/laravel.log \
 && chown -R www-data:www-data /var/www/gestao_alunos/storage \
    /var/www/gestao_alunos/bootstrap/cache \
 && chmod -R 775 /var/www/gestao_alunos/storage \
    && chmod -R 775 /var/www/gestao_alunos/storage/logs \
    && chmod -R 775 /var/www/gestao_alunos/storage/framework/views \
    && chmod -R 775 /var/www/gestao_alunos/bootstrap/cache

WORKDIR /var/www

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm"]
