FROM php:7.4-apache

# Set maintainer.
MAINTAINER Aleksandar Rakić <aleksandar.rakic@yahoo.com>

# Copy self-signed ssl certificates.
COPY ./docker/web/certs/server.crt /etc/apache2/ssl/server.crt
COPY ./docker/web/certs/server.key /etc/apache2/ssl/server.key

# Copy custom apache configuration.
COPY ./docker/web/config/dev.conf /etc/apache2/sites-enabled/dev.conf

# Update and install required os packages.
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zlib1g-dev \
    nodejs \
    npm

# Install required php extensions.
RUN docker-php-ext-install pdo \
    pdo_mysql \
    gd \
    zip \
    sockets

# Install composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# Enable rewrite and ssl mode.
RUN a2enmod rewrite ssl

# Make ports 80 and 443 available to the world outside this container.
EXPOSE 80 443

# Set the working directory in container.
WORKDIR /var/www/html