# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Instal ekstensi sistem dan library yang dibutuhkan Laravel
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
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql bcmath

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Setup DocumentRoot ke folder public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instal Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
COPY . .

# Berikan izin akses folder yang dibutuhkan Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan instalasi composer dengan flag tambahan agar tidak rewel soal ekstensi
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Jalankan Apache
CMD ["apache2-foreground"]