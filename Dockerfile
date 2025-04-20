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

# Fix the ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Set permissions (if needed)
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Update Apache DocumentRoot to /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' >> /etc/apache2/apache2.conf

# Environment variables
ENV APPLICATION_ENV=production

# Expose HTTP
EXPOSE 80

# Run Apache
CMD ["apache2-foreground"]
