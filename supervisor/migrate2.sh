dockerize -wait tcp://redis:6379 -wait tcp://mysql:3306 -timeout 90s
composer install
php /application/artisan generate:key
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf