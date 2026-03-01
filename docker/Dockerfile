FROM dunglas/frankenphp:latest

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip zip \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions pdo_mysql intl opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy only composer files first — this layer is cached unless dependencies change
COPY app/composer.json app/composer.lock /app/

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Now copy the rest of the app code
COPY app/ /app

COPY docker/Caddyfile /etc/frankenphp/Caddyfile

EXPOSE 80