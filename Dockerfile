FROM php:8.2-fpm

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . /var/www/html

EXPOSE 9000

CMD ["php-fpm"]