FROM node:13.14.0-slim

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

RUN npm install -g laravel-echo-server

COPY ./docker/echo/laravel-echo-server.json /var/www/html/laravel-echo-server.json
COPY ./docker/web/certs/* /etc/ssl/certs/

WORKDIR /var/www/html

EXPOSE 6001

CMD ["laravel-echo-server", "start"]