# Use official PHP with Apache image
FROM php:8.0-apache

# Copy all your project files to Apache web root
COPY . /var/www/html/

# Expose port 80 (web server port)
EXPOSE 80
