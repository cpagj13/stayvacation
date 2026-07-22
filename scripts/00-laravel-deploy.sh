#!/usr/bin/env bash
set -e

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

echo "=== Installing Node & building assets ==="
cd /var/www/html
npm ci
npm run build

echo "=== Caching config, routes, views ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Storage symlink ==="
php artisan storage:link || true

echo "=== Setting permissions ==="
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "=== Deploy complete ==="
