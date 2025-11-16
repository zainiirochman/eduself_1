# Gunakan image ini (sudah ada Nginx + PHP)
FROM richarvey/nginx-php-fpm:3.1.6

# --- TAMBAHKAN BAGIAN INI UNTUK MENGINSTAL PGSQL ---
# Kita perlu 'apk' (Alpine Package Manager) dan 'docker-php-ext-install'
# 'postgresql-dev' diperlukan untuk meng-compile ekstensi pdo_pgsql
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del postgresql-dev
# --------------------------------------------------

COPY . .

# Image config
# PASTIKAN INI 0 AGAR COMPOSER BERJALAN
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# PERINTAH TERAKHIR: Jalankan migrasi, LALU nyalakan server
CMD ["sh", "-c", "php artisan migrate --force && /start.sh"]