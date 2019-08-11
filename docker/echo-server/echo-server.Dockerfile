FROM node:12.8.0-slim

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN npm install -g laravel-echo-server

COPY ./laravel-echo-server.json /var/www/laravel-echo-server.json

WORKDIR /var/www

EXPOSE 6001

CMD ["laravel-echo-server","start"]