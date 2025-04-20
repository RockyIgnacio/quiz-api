FROM php:7.4-apache

# Install needed packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install zip \
    && a2enmod rewrite

# Set Apache to serve from /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copy app code into container
COPY . /var/www/html

WORKDIR /var/www/html

# Install Composer + App Dependencies
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --verbose
