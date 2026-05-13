FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev nginx supervisor \
    && docker-php-ext-install pdo_pgsql zip

COPY . /var/www
WORKDIR /var/www

# Права
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]