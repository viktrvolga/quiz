#!/bin/bash

echo "Running migrations and loading fixtures..."

wait-for-it.sh database:5432 --timeout=60 --strict -- echo "Database is up"

php bin/console doctrine:migrations:migrate --no-interaction --env=dev
php bin/console doctrine:fixtures:load --no-interaction --env=dev

exec php-fpm
