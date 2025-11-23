# ===================================================
# STAGE 1 : BUILDER (Compilation et installation des dépendances)
# Objectif : Installer Composer et les vendors de manière propre.
# ===================================================
FROM php:8.4-fpm-alpine AS builder

# 1. Installer les dépendances système nécessaires (git, curl pour composer, icu-dev pour intl)
RUN apk add --no-cache \
    git \
    curl \
    icu-dev

# 2. Installer Composer globalement (Solution pour exit code 127)
# Télécharge et rend l'exécutable 'composer' disponible dans /usr/local/bin
RUN curl -sS getcomposer.org | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Installer les extensions PHP requises par CodeIgniter 4 (Solution pour ext-intl manquant)
# docker-php-ext-install est un script helper fourni par l'image officielle PHP
RUN docker-php-ext-install \
    intl \
    pdo_mysql # Ajoutez d'autres extensions ici si nécessaire (ex: gd, zip, opcache)

# Définit le répertoire de travail dans le conteneur
WORKDIR /app

# Copie uniquement les fichiers de gestion des dépendances depuis votre machine locale
COPY composer.json composer.lock ./

# 4. Exécute l'installation de Composer
# Cette commande fonctionne maintenant car Composer est installé et intl est présent.
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final et léger)
# Objectif : Exécuter l'application sans les outils de développement/build inutiles.
# ===================================================
FROM php:8.4-fpm-alpine AS runtime

# 1. Réinstaller uniquement les extensions PHP nécessaires à l'exécution (pas besoin de git/curl ici)
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

# 2. Copie tous les fichiers du code source local vers le conteneur
COPY . .

# 3. Copie les dépendances installées par Composer depuis le stage 'builder'
COPY --from=builder /app/vendor vendor

# 4. Configure les permissions pour les dossiers de cache et de logs de CodeIgniter
# L'utilisateur www-data est l'utilisateur par défaut de PHP-FPM dans Alpine
RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

# Expose le port par défaut de PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm", "-F"]
