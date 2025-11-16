# Gunakan image ini (sudah ada Nginx + PHP)
FROM richarvey/nginx-php-fpm:3.1.6

# --- PERBAIKAN ---
# Instal ekstensi pdo_pgsql DAN Node.js + NPM
RUN apk add --no-cache \
    postgresql-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql \
    && apk del postgresql-dev
# -----------------

# Salin semua kode aplikasi Anda ke dalam server
COPY . .

# Build aset front-end dan perbaiki izin (permission)
# Sekarang 'npm' akan ditemukan
RUN npm install && npm run build \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Env (sama seperti sebelumnya)
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Perintah start (sama seperti sebelumnya)
# (Ini akan menjalankan composer & migrasi via Env Vars)
CMD ["/start.sh"]