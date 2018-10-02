FROM php:7.2.8-alpine

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN apk --update add \
        wget \
        curl \
        git \
        build-base \
        libxml2-dev \
        zlib-dev \
        autoconf \
        cyrus-sasl-dev \
        libgsasl-dev \
        supervisor \
    && docker-php-ext-install \
        mbstring \
        pdo \
        pdo_mysql \
        xml \
        pcntl \
    && pecl channel-update pecl.php.net \
    && rm /var/cache/apk/* \
    && mkdir -p /var/www

COPY ./docker/queue/supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
