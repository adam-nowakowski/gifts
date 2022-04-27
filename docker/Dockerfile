FROM php:8.1-apache

# Copy virtual host into container
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable rewrite mode
RUN a2enmod rewrite

# Install PHP Extensions
RUN docker-php-ext-install pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update

# Install unzip utility and libs needed by zip PHP extension
RUN apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

# Install neccessary tools
RUN apt-get install --no-install-recommends -y  \
    nodejs \
    npm \
    git


# Change the current working directory
WORKDIR /var/www


