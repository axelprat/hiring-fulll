FROM php:8.2-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt update && apt install -y curl unzip libicu-dev libxml2-dev

RUN docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer self-update

COPY . /var/www/backend
WORKDIR /var/www/backend

RUN docker-php-ext-install pdo pdo_mysql

RUN composer install --no-scripts

CMD php-fpm
