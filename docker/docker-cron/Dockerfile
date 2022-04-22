FROM php:7.4-fpm-alpine

WORKDIR /

RUN docker-php-ext-install pdo pdo_mysql

COPY crontab /etc/crontabs/root
