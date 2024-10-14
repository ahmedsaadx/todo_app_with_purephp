FROM php:8.3-apache
WORKDIR /var/www/html

# Install PHP extensions or any dependencies your app needs
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy the current directory contents into the container
COPY . .

# Expose port 5000 for the app
EXPOSE 5000
