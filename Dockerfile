# Use official PHP-Apache image as base
FROM php:7.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . /var/www/html/

# Set document root to public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use public/ as document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer to install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions (adjust this if needed based on your app structure)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
