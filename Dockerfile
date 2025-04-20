FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zlib1g-dev \
    && docker-php-ext-install zip pdo pdo_mysql mbstring \
    && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose
