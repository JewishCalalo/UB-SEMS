FROM php:8.2-cli

# Install system dependencies including GD and oniguruma
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl sqlite3 libsqlite3-dev zlib1g-dev gnupg libxml2-dev libonig-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_sqlite mbstring bcmath gd

# Install Node.js (via NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /app

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Increase Composer memory limit
ENV COMPOSER_MEMORY_LIMIT=-1

# Install PHP dependencies without running Laravel scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the app
COPY . .

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions for writable directories
RUN chmod -R 775 storage bootstrap/cache database

# Copy and configure entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Expose port for Laravel's built-in server
EXPOSE 80