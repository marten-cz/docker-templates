FROM php:8.0.1-fpm

# TODO: use builder to download composer dependencies

WORKDIR /app/

# Install dependencies
RUN apt-get update && apt-get install -y libzip-dev zip libpq-dev libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) pgsql pdo_pgsql bcmath intl zip

# Install composer
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

COPY ./install/php-entrypoint.sh /app/

# Get application dependencies
COPY ./composer.* /
RUN composer install -o

# Copy application
COPY ./src/ /app/

RUN rm -rf /app/temp /app/log && mkdir /app/log /app/temp && chmod 0755 /app/log /app/temp && chown -R www-data:www-data /app/

USER www-data

CMD bash /php-entrypoint.sh
