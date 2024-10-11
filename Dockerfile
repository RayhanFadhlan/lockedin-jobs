FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN a2enmod rewrite

ENV DOCKER_ENV=true

WORKDIR /var/www/html

COPY php.ini /usr/local/etc/php/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
