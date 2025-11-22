# ---- STAGE 1 : BUILD ----
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ---- STAGE 2 : RUNTIME ----
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy CodeIgniter project files
COPY . .

# Copy vendor from builder stage
COPY --from=vendor /app/vendor ./vendor

# Permissions for writable folder
RUN chown -R www-data:www-data writable \
    && chmod -R 775 writable

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
