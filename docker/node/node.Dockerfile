ARG HTTP_PROXY=""
ARG HTTPS_PROXY=""
ARG NO_PROXY="localhost,127.0.0.*"

FROM node:12.8.0-slim

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ENV http_proxy "${HTTP_PROXY}"
ENV https_proxy "${HTTPS_PROXY}"
ENV no_proxy "${NO_PROXY}"

WORKDIR /var/www/html

# copy package.json and lock files
COPY ./codes/package*.json ./codes/.yarnrc ./codes/yarn.lock ./

# install project dependencies
RUN if [ ! -z "${HTTP_PROXY}" ]; then \
        npm config set proxy "${HTTP_PROXY}" && \
        yarn config set proxy "${HTTP_PROXY}" \
    ;fi && \
    if [ ! -z "${HTTPS_PROXY}" ]; then \
        npm config set https-proxy "${HTTPS_PROXY}" && \
        yarn config set https-proxy "${HTTPS_PROXY}" \
    ;fi && \
    npm install && \
    npm cache clean --force

# copy project files and folders to the current working directory (i.e. 'app' folder)
COPY ./codes/ .

CMD [ "npm", "run", "serve" ]