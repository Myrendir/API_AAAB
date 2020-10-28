#!/bin/bash -x
composer install
./bin/console cache:clear
./bin/console assets:install
./bin/console doctrine:schema:update --force
php-fpm -F
