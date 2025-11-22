# ----- PHP + APACHE -----
FROM php:8.2-apache

# ----- INSTALL EXTENSIONS -----
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git && \
    docker-php-ext-install mysqli pdo pdo_mysql zip

# ----- ENABLE APACHE REWRITE -----
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# ----- INSTALL COMPOSER -----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ----- COPY PROJECT -----
COPY . /var/www/html

# ----- FIX PERMISSIONS -----
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/writable

# ----- INSTALL DEPENDENCIES -----
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --no-dev
RUN composer dump-autoload --optimize

# ----- SET DOCUMENT ROOT TO /public -----
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' \
    /etc/apache2/apache2.conf

# ----- EXPOSE -----
EXPOSE 8080

CMD ["apache2-foreground"]
