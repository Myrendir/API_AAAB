#!/bin/bash -x
composer install
./bin/console cache:clear
./bin/console assets:install
php-fpm -F
