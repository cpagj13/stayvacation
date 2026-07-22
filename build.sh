#!/usr/bin/env bash
set -e

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== Installing Node dependencies ==="
npm ci

echo "=== Building frontend assets ==="
npm run build

echo "=== Caching Laravel config, routes, views ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Running database migrations ==="
php artisan migrate --force

echo "=== Creating storage symlink ==="
php artisan storage:link

echo "=== Setting storage permissions ==="
chmod -R 775 storage bootstrap/cache

echo "=== Build complete ==="
