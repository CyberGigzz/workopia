FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Install necessary packages
RUN apt-get update && \
    apt-get install \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends


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

WORKDIR /var/www/html

COPY .. /var/www/html

COPY ./php.ini /usr/local/etc/php


# ENV COMPOSER_ALLOW_SUPERUSER=1
# COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
# COPY ./composer.* ./
# RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
# RUN composer dump-autoload --optimize

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer