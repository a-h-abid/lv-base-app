FROM redis:5.0.14

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ENV REDIS_PASSWORD "foobared"

COPY ./docker/redis/redis.conf /usr/local/etc/redis/redis.conf

EXPOSE 6379

CMD ["sh", "-c", "exec redis-server /usr/local/etc/redis/redis.conf --requirepass \"$REDIS_PASSWORD\""]