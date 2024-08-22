FROM mysql:8.4.2

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

#####################################
# Set Timezone
#####################################

ARG TZ=UTC
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && chown -R mysql:root /var/lib/mysql/

COPY ./docker/db/my.cnf /etc/mysql/conf.d/my.cnf
COPY ./docker/db/docker-entrypoint-initdb.d /docker-entrypoint-initdb.d

CMD ["mysqld"]

EXPOSE 3306
