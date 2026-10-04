# syntax=docker/dockerfile:1

# ==========================================
# 1. Build frontend assets (Vite)
# ==========================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./

RUN npm run build

# ==========================================
# 2. Install PHP/Composer dependencies
# ==========================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# ==========================================
# 3. Production Laravel application
# ==========================================
FROM php:8.3-apache

WORKDIR /var/www/html

# PHP extensions required by Laravel + PostgreSQL/Supabase
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    unzip \
    git \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        mbstring \
        bcmath \
        intl \
        zip \
        exif \
        opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Laravel must be served from /public, not the repository root.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Composer dependencies
COPY --from=vendor /app/vendor ./vendor

# Application source
COPY . .

# Compiled Vite assets
COPY --from=frontend /app/public/build ./public/build

# Laravel writable directories
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

# Render supplies PORT at runtime. Keep 10000 as the container default.
EXPOSE 10000

CMD ["sh", "-c", "PORT=${PORT:-10000}; sed -ri \"s/^Listen [0-9]+/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -ri \"s/:80>/:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; apache2-foreground"]
