dockerize -wait tcp://redis:6379 -wait tcp://mysql:3306 -timeout 90s
npm install
composer install
php-fpm