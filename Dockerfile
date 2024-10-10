FROM php:8.3-apache
# add configuration here as needed
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]