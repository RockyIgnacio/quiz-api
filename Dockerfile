FROM php:7.4-apache-buster

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    default-libmysqlclient-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip pdo pdo_mysql mbstring

# Enable Apache modules
RUN a2enmod rewrite headers

# Set Composer memory limit
ENV COMPOSER_MEMORY_LIMIT=-1

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Apache DocumentRoot update
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' >> /etc/apache2/apache2.conf

# Debugging step: Check contents of /var/www/html before running composer install
RUN echo "Listing contents of /var/www/html:" && ls -l /var/www/html && \
    if [ -f composer.json ]; then \
    echo "composer.json found, running composer install..."; \
    composer install --no-dev --optimize-autoloader --no-interaction || { echo "Composer install failed!"; exit 1; }; \
    else echo "No composer.json found, skipping composer install."; exit 1; \
    fi

# Set environment variable
ENV APPLICATION_ENV=production

# Expose port 80
EXPOSE 80

# Run Apache in the foreground
CMD ["apache2-foreground"]
