FROM php:8.0-apache

# Copy your app files into the Apache web root
COPY . /var/www/html/

# Fix permissions so Apache can read files
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
