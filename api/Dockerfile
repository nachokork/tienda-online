FROM php:8.3
WORKDIR /var/www/symfony
COPY . .
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]