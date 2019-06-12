#!/bin/sh
/var/www/html/wait-for-it.sh db:3306 -t 60

if grep -Fq "APP_KEY=base64" .env
then
    :
else
    php artisan key:generate
fi

perl -i -pe 's!(HELP_URL)\s*=.*!\1=$ENV{'HELP_URL'}!' .env
perl -i -pe 's!(PRIVACY_URL)\s*=.*!\1=$ENV{'PRIVACY_URL'}!' .env
perl -i -pe 's!(IMPRINT_URL)\s*=.*!\1=$ENV{'IMPRINT_URL'}!' .env

php artisan storage:link
php artisan migrate

# `/var/www/html/storage/app/public/` ist ein Verzeichnis, welches beim Starten
# des Containers in den Container "gemountet" wird. Die Berechtigungen für
# dieses Verzeichnis müssen korrigiert werden
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/resources
chown -R www-data:www-data /var/www/html/public

php-fpm & caddy
