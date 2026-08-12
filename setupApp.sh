#!/bin/bash

echo "Clearing Laravel cache..."

docker compose exec mpira-api php artisan config:clear

echo "Running migrations..."

docker compose exec mpira-api php artisan migrate:fresh --seed

echo "Database setup completed."