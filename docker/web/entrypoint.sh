#!/bin/bash

set -e

sed -i "s/\${NGINX_VHOST_DNS_RESOLVER_IP}/${VHOST_DNS_RESOLVER_IP}/" /etc/nginx/conf.d/default.conf
sed -i "s/\${NGINX_VHOST_UPSTREAM_APP_SERVICE_HOST_PORT}/${VHOST_UPSTREAM_APP_SERVICE_HOST_PORT}/" /etc/nginx/conf.d/default.conf
sed -i "s/\${NGINX_VHOST_UPSTREAM_ECHO_SERVICE_HOST_PORT}/${VHOST_UPSTREAM_ECHO_SERVICE_HOST_PORT}/" /etc/nginx/conf.d/default.conf

exec "$@"
