FROM php:8.3-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql mysqli 

COPY . .

RUN cp .env.example .env
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install


EXPOSE 5000
