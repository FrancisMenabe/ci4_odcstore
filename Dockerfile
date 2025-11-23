# ===================================================
# STAGE 1 : BUILDER (Compilation et installation des dépendances)
# ===================================================
FROM php:8.4-fpm-alpine AS builder

# 1. Installer les dépendances système nécessaires
RUN apk add --no-cache \
    git \
    curl \
    icu-dev # Requis pour l'extension intl

# 2. Installer Composer globalement (LA SOLUTION POUR "composer: not found")
# Cette commande télécharge et rend l'exécutable 'composer' disponible dans /usr/local/bin
RUN curl -sS getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Installer les extensions PHP requises par CodeIgniter 4 (Solution pour ext-intl manquant)
RUN docker-php-ext-install \
    intl \
    pdo_mysql

WORKDIR /app

# Copie uniquement les fichiers de gestion des dépendances depuis votre machine locale
COPY composer.json composer.lock ./

# 4. Exécute l'installation de Composer
# Cette commande fonctionne maintenant car Composer a été installé à l'étape 2.
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final et léger)
# ===================================================
FROM php:8.4-fpm-alpine AS runtime

# Réinstaller uniquement les extensions PHP nécessaires à l'exécution
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

# Copie tous les fichiers du code source local vers le conteneur
COPY . .

# Copie les dépendances installées par Composer depuis le stage 'builder'
COPY --from=builder /app/vendor vendor

# Configure les permissions pour les dossiers de cache et de logs de CodeIgniter
RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

# Expose le port par défaut de PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm", "-F"]
