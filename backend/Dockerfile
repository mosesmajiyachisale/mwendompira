FROM php:8.3-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql zip

# Enable Laravel URL rewriting
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install

# Point Apache to Laravel public folder
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]