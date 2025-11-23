# ===================================================
# STAGE 1 : BUILDER (Préparation des dépendances)
# ===================================================
FROM php:8.1-fpm-alpine AS builder

# 1. Installer les outils système nécessaires (git, curl, icu-dev)
RUN apk add --no-cache git curl icu-dev

# 2. Installer Composer globalement (C'EST LA SOLUTION)
# Cette commande télécharge et rend 'composer' disponible dans /usr/local/bin
RUN curl -sS getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Installer les extensions PHP requises
RUN docker-php-ext-install intl pdo_mysql

WORKDIR /app

# Copie uniquement les fichiers de gestion des dépendances
COPY composer.json composer.lock ./

# 4. Exécute l'installation de Composer
# Cette ligne fonctionne maintenant car Composer a été installé à l'étape 2.
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final)
# ===================================================
FROM php:8.1-fpm-alpine AS runtime

# Réinstaller uniquement les extensions PHP nécessaires
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

COPY . .
COPY --from=builder /app/vendor vendor

RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

EXPOSE 9000

CMD ["php-fpm", "-F"]
