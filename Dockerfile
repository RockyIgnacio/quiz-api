# Use the official PHP image with Apache
FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite (commonly needed for frameworks)
RUN a2enmod rewrite

# Fix the Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Replace default port 80 with 8080 (Railway expects 8080)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Copy your app into the container (adjust path as needed)
COPY . /var/www/html/

# Set correct document root if your index is in /public
# RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Set permissions (optional: make this more specific if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port 8080
EXPOSE 8080

# Railway uses PORT env internally; this helps avoid binding issues
ENV PORT=8080

# Start Apache in the foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]
