# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Instal semua dependensi sistem dan ekstensi PHP yang umum dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql bcmath intl

# Aktifkan mod_rewrite Apache agar routing Laravel bekerja
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instal Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory ke dalam container
WORKDIR /var/www/html
COPY . .

# Hapus folder vendor & composer.lock bawaan jika tidak sengaja ter-push ke git
RUN rm -rf vendor

# Jalankan instalasi composer murni (fresh) tanpa plugin/scripts mengganggu
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs

# Berikan izin akses folder setelah vendor terinstal sempurna
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/vendor

# Jalankan Apache di foreground
CMD ["apache2-foreground"]