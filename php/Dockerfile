FROM php:7.1.2-apache
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
ADD php.ini /usr/local/etc/php/php.ini
ADD php.ini /usr/local/etc/php/php.ini

