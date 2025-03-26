# Use an official PHP image with Apache
FROM php:8.4-apache

# Install dependencies
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy project files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Expose Apache port
EXPOSE 80
