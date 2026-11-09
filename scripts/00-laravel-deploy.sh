#!/usr/bin/env bash
echo "=== Running Laravel Deployment Script on Render ==="

# Create and set permissions for SQLite database if not using external DB
mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chmod -R 777 /var/www/html/database
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# Run database migrations
php /var/www/html/artisan migrate --force

echo "=== Laravel Deployment Script Finished ==="
