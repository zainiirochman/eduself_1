# Gunakan image ini (sudah ada Nginx + PHP)
FROM richarvey/nginx-php-fpm:3.1.6

# Instal ekstensi pdo_pgsql untuk PostgreSQL
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del postgresql-dev

COPY . .

# --- KONFIGURASI PENTING ---
# 0 = JALANKAN composer install. 1 = LEWATI.
# Kita set 0 (atau hapus baris ini) agar composer berjalan.
ENV SKIP_COMPOSER 0
# ---------------------------

# Konfigurasi sisa
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# KEMBALIKAN CMD KE ASLINYA.
# Script /start.sh akan menangani composer DAN migrasi (via Env Var).
CMD ["/start.sh"]