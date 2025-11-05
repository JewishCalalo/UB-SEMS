FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl sqlite3 libsqlite3-dev zlib1g-dev gnupg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_sqlite

# Install Node.js (via NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /app

# Copy Laravel project files
COPY . .

# Install Composer globally and Laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Copy and configure entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Expose port for Laravel's built-in server
EXPOSE 80