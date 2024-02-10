FROM slothdevdocker/php:8.2-debian-apache

USER root

RUN a2enmod headers

ENV HTTP_PORT=8080

USER code

COPY --chown=code:code . /app

RUN composer install --prefer-dist

RUN php artisan optimize:clear \
#    && php artisan config:cache \
#    && php artisan event:cache \
#    && php artisan route:cache \
    && php artisan map:models

EXPOSE $HTTP_PORT
