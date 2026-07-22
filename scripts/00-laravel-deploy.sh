#!/usr/bin/env bash
set -e

echo "=== Caching config, routes, views ==="
php /app/artisan config:cache
php /app/artisan route:cache
php /app/artisan view:cache

echo "=== Running migrations ==="
php /app/artisan migrate --force

echo "=== Storage symlink ==="
php /app/artisan storage:link || true

echo "=== Deploy complete ==="
