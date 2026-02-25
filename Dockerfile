FROM php:8.2-fpm-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev; \
    docker-php-ext-install pdo_pgsql; \
    apk del .build-deps

COPY . /var/www/html/
EXPOSE 9000
