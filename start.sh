#!/bin/sh
set -e

echo "==> Clearing caches..."
php artisan config:clear
php artisan cache:clear 2>/dev/null || true

echo "==> Caching config & routes..."
php artisan config:cache
php artisan route:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Starting server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
