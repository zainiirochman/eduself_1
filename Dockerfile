# --- Build Stage ---
FROM php:8.3-fpm AS build

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
WORKDIR /var/www
COPY . .

# Install packages
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Run Laravel optimization
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# --- Production Stage ---
FROM nginx:stable

COPY --from=build /var/www/public /var/www/public
COPY deploy/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
