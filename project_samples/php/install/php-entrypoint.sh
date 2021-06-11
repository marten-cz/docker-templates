#!/usr/bin/env bash

cd /app/

# Run Doctrine database migrations
php bin/console.php --no-interaction migration:migrate
php bin/console.php orm:generate-proxies

# Start PHP FPM
php-fpm
