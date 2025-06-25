# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install all required system packages
RUN apt-get update && apt-get install -y \
    ffmpeg \
    curl \
    unzip \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    default-mysql-client \
    && docker-php-ext-install mysqli zip

    # Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache rewrite module (for clean URLs)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into container
COPY . /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80 (Apache default)
EXPOSE 80
