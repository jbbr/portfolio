#!/bin/sh
/var/www/html/wait-for-it.sh db:3306 -t 60

# `/var/www/html/storage/app/public/` ist ein Verzeichnis, welches beim Starten
# des Containers in den Container "gemountet" wird. Die Berechtigungen für
# dieses Verzeichnis müssen korrigiert werden
chown -R www-data:www-data /var/www/html

php artisan key:generate
php artisan storage:link
php artisan migrate

php-fpm &
caddy