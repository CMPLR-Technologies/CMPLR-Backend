FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Set working directory
WORKDIR /var/www

COPY . .
RUN composer update
RUN composer install


RUN php artisan migrate:fresh --seed --env=testing
RUN php artisan passport:install --env=testing
RUN php artisan test --env=testing

EXPOSE 8000



CMD php artisan serve --host=0.0.0.0 --port=8000
