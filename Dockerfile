# ============================================
# Stage 1 — Build composer dependencies
# ============================================
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --ignore-platform-reqs --no-dev --no-interaction --prefer-dist

COPY . .
RUN composer dump-autoload --optimize


# ============================================
# Stage 2 — Production (PHP 8.2 + nginx)
# ============================================
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

WORKDIR /var/www

# Copy source code + vendor from build stage
COPY . .
COPY --from=vendor /app/vendor ./vendor

# Copy nginx + supervisor config
COPY deploy/nginx.conf /etc/nginx/sites-enabled/default
COPY deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord"]
