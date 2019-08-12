FROM redis:5.0.5-alpine

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

COPY ./docker/redis/redis.conf /usr/local/etc/redis/redis.conf

EXPOSE 6379

CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]