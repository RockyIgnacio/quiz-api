# Use official PHP 7.4 with Apache
FROM php:7.4-apache

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        intl

# Enable Apache mod_rewrite (needed for Zend routes)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy all files to the container
COPY . .

# Set document root to the 'public' folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use public/ as document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer manually
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --prefer-dist --no-interaction

# Set proper permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose web port
EXPOSE 80
