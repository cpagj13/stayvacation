#!/usr/bin/env bash
# Local helper script — on Render the Docker image handles the build.
# Run this locally to test the production setup.
set -e

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== Installing Node dependencies ==="
npm ci

echo "=== Building frontend assets ==="
npm run build

echo "=== Done ==="
