FROM nginx:1.15.2-alpine

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ADD ./docker/web/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

EXPOSE 80