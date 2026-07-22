#!/usr/bin/env bash
set -e

echo "=== Caching config, routes, views ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Creating storage symlink ==="
php artisan storage:link || true

echo "=== Deploy complete ==="
