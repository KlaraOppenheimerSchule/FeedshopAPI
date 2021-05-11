FROM composer:2.0 AS composer

FROM php:7.4-fpm

RUN apt-get update && \
     apt-get install -y sudo && \
     apt-get install -y curl nano && \
     apt-get install -y git-all && \
     apt-get install -y zip unzip

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install json

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /srv

COPY . .