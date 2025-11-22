# ---- STAGE 1 : BUILD ----
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

# Ignore ext-intl if missing (optionnel)
RUN composer install --no-dev --prefer-dist --optimize-autoloader || composer install --no-dev --prefer-dist --optimize-autoloader --ignore-platform-req=ext-intl

# ---- STAGE 2 : RUNTIME ----
FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libicu-dev \
 && docker-php-ext-install mysqli pdo pdo_mysql zip intl

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Copy vendor from builder
COPY --from=vendor /app/vendor ./vendor

# Permissions for writable folder
RUN chown -R www-data:www-data writable \
    && chmod -R 775 writable

# Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
