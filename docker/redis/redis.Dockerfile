FROM redis:5.0.5-alpine

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

COPY ./docker/redis/redis.conf /usr/local/etc/redis/redis.conf

VOLUME /data

EXPOSE 6379

CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
#CMD ["redis-server"]
