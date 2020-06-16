FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    mariadb-client \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev && \
    docker-php-ext-configure gd --with-freetype --with-webp  --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql gd exif opcache

WORKDIR /var/www
