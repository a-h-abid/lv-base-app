FROM node:12.8.0-slim

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN npm install -g laravel-echo-server

COPY ./docker/echo-server/laravel-echo-server.json /var/www/html/laravel-echo-server.json

WORKDIR /var/www/html

EXPOSE 6001

CMD ["laravel-echo-server", "start"]