FROM php:7.2.8-fpm

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install gd \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && rm -rf /tmp/pear \
    && curl -s http://getcomposer.org/installer | php \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer \
    && . ~/.bashrc

#COPY ./docker/app/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/app-php.ini
