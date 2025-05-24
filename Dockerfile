FROM php:8.0-apache

COPY . /var/www/html/
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

RUN a2enmod rewrite
