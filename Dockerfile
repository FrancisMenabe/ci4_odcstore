# ----- IMAGE PHP + APACHE -----
FROM php:8.2-apache

# ----- INSTALL EXTENSIONS NÉCESSAIRES -----
RUN apt-get update && apt-get install -y \
    libzip-dev unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql zip

# ----- ACTIVER MOD_REWRITE POUR CI4 -----
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# ----- INSTALLER COMPOSER -----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ----- COPIER LE PROJET -----
COPY . /var/www/html

# ----- INSTALLATION DEPENDANCES -----
RUN composer install --no-dev --optimize-autoloader

# ----- DONNER LES PERMISSIONS POUR writable/ -----
RUN chown -R www-data:www-data /var/www/html/writable
RUN chmod -R 775 /var/www/html/writable

# ----- CONFIG DOCUMENT ROOT -----
WORKDIR /var/www/html/public

# Render utilise le PORT environment variable
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Modifier Apache pour pointer vers /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# ----- PORT -----
EXPOSE 8080

# ----- START APACHE -----
CMD ["apache2-foreground"]
