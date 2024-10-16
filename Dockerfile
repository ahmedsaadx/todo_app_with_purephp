FROM php:8.2-cli
RUN apt-get update && apt-get install -y zip unzip 


RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY . /usr/src/myapp

WORKDIR /usr/src/myapp
RUN cp .env.example .env

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install


CMD ["php", "-S", "0.0.0.0:5000" ]
