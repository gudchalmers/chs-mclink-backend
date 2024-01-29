FROM php:8.2-apache

RUN apt-get update && \
  apt-get install -y git unzip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/

COPY . .
RUN composer install --optimize-autoloader --no-dev

RUN mv public/* /var/www/html/

RUN chown -R www-data:www-data /var/www/

EXPOSE 80