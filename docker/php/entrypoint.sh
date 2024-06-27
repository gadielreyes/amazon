#!/bin/bash

composer install

php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction

npm install
npm run dev

php-fpm