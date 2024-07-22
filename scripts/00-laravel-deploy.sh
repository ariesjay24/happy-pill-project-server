#!/usr/bin/env bash
echo "Running composer..."
composer install --optimize-autoloader --no-dev

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders"
php artisan db:seed --class=AdminSeeder --force
php artisan db:seed --class=ServiceSeeder --force

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT