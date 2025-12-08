FROM php:8.2-fpm

# Set working directory early
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 18.x (newer version for better compatibility)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions including GD and MySQL
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Install npm dependencies (including docx for agreement generation)
RUN npm ci && npm run build

# Install docx package specifically for agreement generation
RUN npm install docx --save

# Create storage directories with proper permissions
RUN mkdir -p storage/app/agreements \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Change ownership of entire application
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 8000

# Start application
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}