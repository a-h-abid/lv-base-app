FROM node:10.8.0

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN apt-get update -yqq \
    && apt-get install -y --no-install-recommends \
        libjpeg-dev \
        libpng-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
