web: vendor/bin/heroku-php-apache2 public/
postdeploy: php artisan migrate --no-interaction --force && php artisan storage:link && php artisan db:seed --class=AdminUserSeeder --force
