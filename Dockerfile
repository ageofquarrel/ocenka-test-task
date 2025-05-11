# Use PHP 8.3 with FPM
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libzip-dev libonig-dev libpq-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libmcrypt-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
COPY . .

# Ensure required directories exist before changing ownership
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
