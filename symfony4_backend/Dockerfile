FROM php:8.1-fpm

WORKDIR /app

RUN apt-get update && \
    apt-get install -y unzip git libpq-dev && \
    docker-php-ext-install pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Install the dependencies
COPY composer.json composer.lock /app/

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --prefer-dist --no-scripts


# Copy the application code
COPY . /app

# Runs Composer scripts
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

CMD ["php-fpm"]