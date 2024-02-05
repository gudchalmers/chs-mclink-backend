FROM php:8.2-apache

WORKDIR /var/www/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
  install-php-extensions mbstring mysqli pdo pdo_mysql openssl

RUN apt-get update && \
  apt-get install -y git unzip curl

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY . .
RUN composer install --optimize-autoloader --no-dev

RUN mv public/* /var/www/html/

RUN chown -R www-data:www-data /var/www/

EXPOSE 80