# ===================================================
# STAGE 1 : BUILDER (Compilation et installation des dépendances)
# ===================================================
# Utilise une image PHP Alpine avec FPM (FastCGI Process Manager)
FROM php:8.4-fpm-alpine AS builder

# Installe les dépendances système nécessaires pour PHP, Composer et Git
# apk est le gestionnaire de paquets d'Alpine
RUN apk add --no-cache \
    git \
    icu-dev # Requis pour l'extension intl

# Installe les extensions PHP requises par CodeIgniter 4 et votre projet
# docker-php-ext-install est un script helper fourni par l'image officielle PHP
RUN docker-php-ext-install \
    intl \
    pdo_mysql # Ajoutez d'autres extensions ici si nécessaire (ex: gd, zip, opcache)

# Définit le répertoire de travail dans le conteneur
WORKDIR /app

# Copie uniquement les fichiers de gestion des dépendances
COPY composer.json composer.lock ./

# Exécute l'installation de Composer
# L'extension intl est maintenant disponible, donc cela ne devrait plus échouer
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# ===================================================
# STAGE 2 : RUNTIME (Environnement d'exécution final)
# ===================================================
# Utilise la même image de base propre pour le runtime
FROM php:8.4-fpm-alpine AS runtime

# Installe les extensions nécessaires pour l'exécution (elles doivent être les mêmes que dans le builder)
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl pdo_mysql

WORKDIR /app

# Copie tous les fichiers du répertoire de travail local vers le conteneur
# Assurez-vous que le reste de votre code source est présent localement
COPY . .

# Copie les dépendances installées par Composer depuis le stage 'builder'
COPY --from=builder /app/vendor vendor

# Configure les permissions pour les dossiers de cache et de logs de CodeIgniter
# Cela permet au serveur web (souvent www-data dans Alpine) d'écrire dans ces dossiers
RUN chown -R www-data:www-data writable/cache writable/logs writable/sessions writable/uploads

# Expose le port par défaut de PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm", "-F"]

# ===================================================
