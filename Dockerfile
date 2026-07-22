# ─── Stage 1: Build frontend assets ────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# ─── Stage 2: Production PHP + Nginx image ──────────────────────────────────────
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copy full source code
COPY . .

# Copy built assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Fix storage permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R nginx:nginx storage bootstrap/cache

CMD ["/start.sh"]
