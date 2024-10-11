FROM php:8.3-apache
# add configuration here as needed
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY php/src /var/www/html
COPY .env /var/www/html/.env

COPY php/php.ini /usr/local/etc/php/


RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html