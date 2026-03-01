FROM dunglas/frankenphp:latest

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip zip \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions pdo_mysql intl opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY app/ /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts \
    && php bin/console cache:clear

COPY docker/Caddyfile /etc/frankenphp/Caddyfile

EXPOSE 80