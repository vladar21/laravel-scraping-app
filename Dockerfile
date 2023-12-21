# Use the PHP 8.1 image
FROM php:8.1

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy all files from the current directory into the container
COPY . .

# Install Laravel dependencies
RUN composer install

# Run migrations and seed the database
RUN php artisan migrate --seed

# Optionally: Start the PHP web server
CMD [ "php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000" ]
