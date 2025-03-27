# Use an official PHP image with Apache
FROM php:8.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

COPY composer.json composer.lock ./

# Set the working directory to the web root
WORKDIR /var/www/html/

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
COPY . .

CMD apache2-foreground

