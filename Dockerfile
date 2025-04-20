FROM php:7.4-apache

# Install needed packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install zip \
    && a2enmod rewrite

# Change DocumentRoot to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copy code to container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Composer install (separated for clarity)
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose
