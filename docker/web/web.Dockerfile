FROM node:13.12.0-slim as build-assets

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ARG HTTP_PROXY=""
ARG HTTPS_PROXY=""
ARG NO_PROXY="localhost,127.0.0.*"

ENV http_proxy "${HTTP_PROXY}"
ENV https_proxy "${HTTPS_PROXY}"
ENV no_proxy "${NO_PROXY}"

WORKDIR /var/www/html

COPY ./codes/.yarnrc ./codes/package*.json ./codes/yarn.lock* ./

RUN if [ ! -z "${HTTP_PROXY}" ]; then \
        npm config set proxy "${HTTP_PROXY}" && \
        yarn config set proxy "${HTTP_PROXY}" \
    ;fi && \
    if [ ! -z "${HTTPS_PROXY}" ]; then \
        npm config set https-proxy "${HTTPS_PROXY}" && \
        yarn config set https-proxy "${HTTPS_PROXY}" \
    ;fi

RUN npm install

COPY ./codes/ .

RUN npm run prod


# ------------------------------------------------------------------
FROM nginx:1.25.3

ARG VHOST_DNS_RESOLVER_IP="127.0.0.11"
ARG VHOST_UPSTREAM_APP_SERVICE_HOST_PORT="app:9000"
ARG VHOST_UPSTREAM_ECHO_SERVICE_HOST_PORT="echo:6001"

ENV VHOST_DNS_RESOLVER_IP=${VHOST_DNS_RESOLVER_IP}
ENV VHOST_UPSTREAM_APP_SERVICE_HOST_PORT=${VHOST_UPSTREAM_APP_SERVICE_HOST_PORT}
ENV VHOST_UPSTREAM_ECHO_SERVICE_HOST_PORT=${VHOST_UPSTREAM_ECHO_SERVICE_HOST_PORT}

COPY --chown=root:root ./docker/web/nginx.conf /etc/nginx/nginx.conf
COPY --chown=root:root ./docker/web/vhost.conf /etc/nginx/conf.d/default.conf
COPY --chown=root:root ./docker/web/certs/* /etc/ssl/certs/
COPY --chown=www-data:www-data ./docker/web/entrypoint.sh /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

COPY --chown=www-data:www-data --from=build-assets /var/www/html/public /var/www/html/public

RUN chown -R www-data:www-data /var/www/html \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443

ENTRYPOINT [ "/usr/local/bin/entrypoint.sh" ]

CMD ["nginx"]
