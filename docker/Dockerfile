FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY .. /var/www/html

COPY ./php.ini /usr/local/etc/php

# Install necessary packages
RUN apt-get update && \
    apt-get install \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends

# obtain composer using multi-stage build
# https://docs.docker.com/build/building/multi-stage/
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
    
# allow super user - set this if you use Composer as a
# super user at all times like in docker containers
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY ./composer.* .

# install
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

# run composer dump-autoload --optimize
RUN composer dump-autoload --optimize

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo '<Directory /var/www/html/public>\n\
Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf


# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
