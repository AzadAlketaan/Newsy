FROM php:8.0-fpm

WORKDIR /var/www/html

COPY composer.json .
RUN composer install

COPY . .

CMD ["php", "artisan", "serve"]