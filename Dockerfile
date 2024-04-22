FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

# Copy custom Apache configuration
# COPY apache.conf /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . /var/www/html

# CMD [ "php", "./index.php" ]
