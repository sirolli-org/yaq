# Multi-stage build for rootless Laravel 13 container with Apache
FROM node:24-bookworm-slim AS node-builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm ci --no-audit && npm run build

FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

FROM php:8.4-apache-bookworm

# Install system dependencies and PHP extensions required by Laravel.
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libpng-dev \
    libpq-dev \
    libsqlite3-dev \
    libxml2-dev \
    libzip-dev \
    sqlite3 \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        gd \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        zip \
    && a2enmod expires headers rewrite \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/app/public \
    APACHE_LISTEN_PORT=8080

WORKDIR /app

# Copy application source.
COPY --chown=www-data:www-data composer.json composer.lock ./
COPY --chown=www-data:www-data app ./app
COPY --chown=www-data:www-data bootstrap ./bootstrap
COPY --chown=www-data:www-data config ./config
COPY --chown=www-data:www-data database ./database
COPY --chown=www-data:www-data resources ./resources
COPY --chown=www-data:www-data routes ./routes
COPY --chown=www-data:www-data artisan ./artisan
COPY --chown=www-data:www-data .env.example ./.env
COPY --chown=www-data:www-data public ./public

# Copy built assets from the node stage.
COPY --from=node-builder --chown=www-data:www-data /app/public/build ./public/build

# Configure Apache for Laravel and an unprivileged port.
COPY containers/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN sed -ri 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf \
    && printf 'ServerName localhost\n' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Copy PHP dependencies from the composer stage.
COPY --from=composer-builder --chown=www-data:www-data /app/vendor ./vendor

# Prepare writable application paths and runtime directories.
RUN mkdir -p \
        bootstrap/cache \
        storage/app/private \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/testing \
        storage/framework/views \
        storage/logs \
        /var/run/apache2 \
        /var/lock/apache2 \
        /var/log/apache2 \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /app /var/run/apache2 /var/lock/apache2 /var/log/apache2

# Generate an application key for the image defaults.
RUN php artisan key:generate --force

USER www-data

HEALTHCHECK --interval=30s --timeout=10s --start-period=10s --retries=3 \
    CMD curl -fsS http://127.0.0.1:8080/up || exit 1

EXPOSE 8080

CMD ["apache2-foreground"]
