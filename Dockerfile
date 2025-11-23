# ---------------------------
# STAGE 1 : BUILD (Composer)
# ---------------------------
FROM composer:2 AS vendor

WORKDIR /app

# Copier uniquement les fichiers Composer
COPY composer.json composer.lock ./

# Installer les dépendances PHP du projet
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ---------------------------
# STAGE 2 : RUNTIME (Apache + PHP)
# ---------------------------
FROM php:8.2-apache

# Activer mod_rewrite pour CodeIgniter
RUN a2enmod rewrite

# Installer extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev zip unzip libzip-dev git \
 && docker-php-ext-install mysqli pdo pdo_mysql intl zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tous les fichiers du projet
COPY . .

# Copier le dossier vendor depuis le stage Composer
COPY --from=vendor /app/vendor ./vendor

# Configurer les permissions pour le dossier writable
RUN chown -R www-data:www-data writable \
 && chmod -R 775 writable

# Configurer le document root sur public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80

# Lancer Apache en foreground
CMD ["apache2-foreground"]
