# ===================================================
# STAGE 1 : BUILDER (PHP 8.1 FPM Alpine)
# ===================================================
FROM php:8.1-fpm-alpine AS builder

# 1. Installe les outils système requis (git, curl, icu-dev)
RUN apk add --no-cache git curl icu-dev

# 2. Installe les extensions PHP requises par CodeIgniter 4
RUN docker-php-ext-install intl pdo_mysql

# -------------------------------------------------------------
# LA SOLUTION ULTIME POUR L'ERREUR 127 : Installer Composer dans /usr/local/bin
# -------------------------------------------------------------
RUN curl -sS getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Copie les fichiers de gestion des dépendances
COPY composer.json composer.lock ./

# 3. Exécute l'installation de Composer
# Maintenant, le binaire est bien dans le PATH, cette commande doit réussir.
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final et léger)
# ===================================================
FROM php:8.1-fpm-alpine AS runtime

RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

COPY . .
COPY --from=builder /app/vendor vendor

RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

EXPOSE 9000
CMD ["php-fpm", "-F"]
