# Use PHP 8.2 FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libonig-dev \
    libzip-dev \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy all project files
COPY . .

# Install Node dependencies and build frontend
RUN npm install
RUN npm run build

# Ensure storage and cache are writable
RUN mkdir -p storage/framework/cache storage/framework/views storage/framework/sessions bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
