# Use the official PHP 7.4 image with Apache
FROM php:7.4-apache

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install zip pdo pdo_mysql mbstring \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*  # Clean up to reduce image size

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy application files into the container
COPY . /var/www/html

# Set environment variable for application environment
ENV APPLICATION_ENV=production

# Expose the necessary port
EXPOSE 80

# Start Apache in the background
CMD ["apache2-foreground"]
