# Gunakan image PHP resmi dengan Apache untuk Laravel
FROM php:8.2-apache

# Instal ekstensi sistem yang diperlukan untuk Laravel (ditambahkan libpq-dev)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# Aktifkan mod_rewrite Apache agar routing Laravel bekerja
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instal Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh isi project ke dalam container
WORKDIR /var/www/html
COPY . .

# Berikan izin akses folder storage dan bootstrap/cache agar Laravel bisa menulis log/session
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan instalasi composer untuk produksi
RUN composer install --no-dev --optimize-autoloader

# Jalankan perintah Apache di foreground
CMD ["apache2-foreground"]