FROM php:7.3-fpm

RUN apt-get update && apt-get install -y mariadb-client \
    && docker-php-ext-install pdo_mysql

RUN apt-get update && \
    apt-get install -y \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-webp-dir=/usr/include/  --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd exif

WORKDIR /var/www