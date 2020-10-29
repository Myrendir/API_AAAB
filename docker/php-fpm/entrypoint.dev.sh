#!/bin/bash -x
composer install
./bin/console cache:clear
./bin/console assets:install
./bin/console doctrine:schema:update --force
./bin/console doctrine:fixtures:load --no-interaction
php-fpm -F
