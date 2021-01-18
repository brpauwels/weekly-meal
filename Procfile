web: heroku-php-nginx -C etc/heroku/nginx.conf -i etc/heroku/php.ini public/
release: bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
