# Use the base image of PHP-FPM with Alpine
FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    jpeg-dev \
    bash \
    postgresql-dev \
    autoconf \
    build-base

# Install PHP extensions required for Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy the Laravel application to the container
COPY . /var/www

# Copiar el archivo php.ini personalizado
COPY .docker/php/php.ini /usr/local/etc/php/

# Crear el directorio para los logs de PHP
#RUN mkdir -p /var/log/php && \
#    chown -R www-data:www-data /var/log/php

# Change permissions for storage and cache directories
#RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Set PHP memory limit
ARG PHP_MEMORY_LIMIT=512M
RUN echo "memory_limit = ${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/memory-limit.ini

# Expose port 9000 (default for php-fpm)
EXPOSE 9000

# Default command to start php-fpm
CMD ["php-fpm"]



## Usar una imagen base de PHP con FPM y Alpine para un entorno ligero
#FROM php:8.3-fpm-alpine
#
## Configurar el directorio de trabajo
#WORKDIR /var/www/html
#
## Instalar dependencias necesarias
#RUN apk add --no-cache \
#    git \
#    curl \
#    libpng-dev \
#    libjpeg-turbo-dev \
#    libwebp-dev \
#    libxpm-dev \
#    freetype-dev \
#    zip \
#    unzip \
#    icu-dev \
#    oniguruma-dev \
#    libzip-dev \
#    jpegoptim optipng pngquant gifsicle \
#    vim \
#    unzip \
#    jpeg-dev \
#    bash \
#    postgresql-dev \
#    autoconf \
#    build-base
#
## Instalar extensiones de PHP necesarias para Laravel
#RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
#    docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl zip
#
## Install Redis extension
#RUN pecl install redis && docker-php-ext-enable redis
#
## Instalar Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#
## Copiar el código fuente de Laravel
#COPY . /var/www/html
#
## Asignar los permisos necesarios
#RUN chown -R www-data:www-data /var/www/html \
#    && chmod -R 755 /var/www/html/storage \
#    && chmod -R 755 /var/www/html/bootstrap/cache
#
## Instalar las dependencias de Composer
#RUN composer install --no-dev --optimize-autoloader
#
## Set PHP memory limit
#ARG PHP_MEMORY_LIMIT=512M
#RUN echo "memory_limit = ${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/memory-limit.ini
#
## Exponer el puerto 9000 para PHP-FPM
#EXPOSE 9000
#
## Default command to start php-fpm
#CMD ["php-fpm"]
#
