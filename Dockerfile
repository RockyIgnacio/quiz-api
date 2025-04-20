# Use the official PHP 7.4 image with Apache
FROM php:7.4-apache

# Update apt-get and install dependencies
RUN apt-get update

# Install necessary packages
RUN apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev

# Install PHP extensions
RUN docker-php-ext-install zip pdo pdo_mysql mbstring

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Clean up to reduce image size
RUN rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Set environment variable for application environment
ENV APPLICATION_ENV=production

# Expose the necessary port
EXPOSE 80

# Start Apache in the background
CMD ["apache2-foreground"]
