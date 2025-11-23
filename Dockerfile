# ===================================================
# STAGE 1 : BUILDER (Préparation des dépendances)
# Utilise PHP 8.1 FPM sur Alpine Linux
# ===================================================
FROM php:8.1-fpm-alpine AS builder

# 1. Installer les outils système nécessaires (git, curl pour composer, icu-dev pour intl)
RUN apk add --no-cache \
    git \
    curl \
    icu-dev

# 2. Installer Composer globalement (Solution pour "composer: not found")
RUN curl -sS getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Installer les extensions PHP requises par CodeIgniter 4
RUN docker-php-ext-install \
    intl \
    pdo_mysql # Ajoutez d'autres extensions ici si nécessaire (ex: gd, zip)

WORKDIR /app

# Copie uniquement les fichiers de gestion des dépendances
COPY composer.json composer.lock ./

# 4. Exécute l'installation de Composer
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final et léger)
# ===================================================
FROM php:8.1-fpm-alpine AS runtime

# Réinstaller uniquement les extensions PHP nécessaires à l'exécution
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

# Copie tous les fichiers du code source local vers le conteneur
COPY . .

# Copie les dépendances installées par Composer depuis le stage 'builder'
COPY --from=builder /app/vendor vendor

# Configuration des permissions pour les dossiers de cache et de logs de CodeIgniter
RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

# Expose le port par défaut de PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm", "-F"]
