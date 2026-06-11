FROM richarvey/nginx-php-fpm:latest

# Salin seluruh kodingan Laravel ke dalam server
COPY . /var/www/app

# Setelan environment dasar untuk mengarahkan rute ke folder public
ENV WEBROOT /var/www/app/public
ENV APP_ENV production

# Jalankan instalasi library Laravel di dalam server
RUN composer install --no-dev --allow-plugins

# Buka akses port web
EXPOSE 80