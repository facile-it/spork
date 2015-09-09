FROM php:cli

## SYSTEM ##

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git  \
        vim  \
        wget \
    && rm -rf /var/lib/apt/lists/*

##  PHP  ##

# create php.ini
RUN echo "short_open_tag = Off" >> /usr/local/etc/php/php.ini
RUN echo "date.timezone = Europe/Rome" >> /usr/local/etc/php/php.ini

# install basic extensions
RUN docker-php-ext-install opcache
RUN docker-php-ext-install mbstring

# install zip extension (required by Composer)
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install zip

# install intl extension
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        g++ \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install intl

# install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer

# install PhpUnit
RUN wget https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit

# install modules for Spork
docker-php-ext-install pcntl
docker-php-ext-install shmop
