#!/bin/sh
set -e

echo "==> Running migrations..."
if [ "$FRESH_DB" = "1" ]; then
  echo "==> FRESH_DB=1 detected, dropping and recreating all tables..."
  php artisan migrate:fresh --force
  echo "==> Seeding initial data..."
  php artisan db:seed --class=StoryTaleSeeder --force 2>/dev/null || true
else
  php artisan migrate --force
fi

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Starting server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
