# Use an official PHP image with Apache
FROM php:8.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application files
COPY . /var/www/html/

# Set the working directory to the web root
WORKDIR /var/www/html/

CMD bash -c "composer install php --no-dev --optimize-autoloader" && php ./database/seeders/migrate.php && php ./database/seeders/seed.php && apache2-foreground

