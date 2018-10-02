FROM redis:4.0.11-alpine

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

VOLUME /data

EXPOSE 6379

#CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
CMD ["redis-server"]
