FROM php:8.0.1-fpm

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y libzip-dev zip libpq-dev libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) pgsql pdo_pgsql bcmath intl zip

# Add composer
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer


# Copy application
COPY ./src ./
