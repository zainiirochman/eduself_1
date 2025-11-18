# ================================================
# Stage 1 — Composer Dependencies
# ================================================
FROM composer:2 AS composer_stage
WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy project
COPY . .

RUN composer dump-autoload --optimize


# ================================================
# Stage 2 — PHP 8.2 + Nginx + Supervisor
# ================================================
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

WORKDIR /var/www

# Copy Laravel application from build stage
COPY --from=composer_stage /var/www /var/www

# Copy Nginx config
COPY deploy/nginx.conf /etc/nginx/sites-enabled/default

# Copy supervisor config
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Laravel storage + cache folder permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord"]
