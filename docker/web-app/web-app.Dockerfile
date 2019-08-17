FROM php:7.3.8-fpm

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ARG HTTP_PROXY=""
ARG HTTPS_PROXY=""
ARG NO_PROXY="localhost,127.0.0.*"
ARG BUILD_MODE="prod"
ARG TIMEZONE="UTC"

ARG APT_DEPENDENCIES="curl zip unzip gettext libz-dev libpq-dev libssl-dev libzip-dev zlib1g-dev libicu-dev libfreetype6-dev libjpeg-dev libpng-dev g++ openssl ca-certificates nginx supervisor"
ARG PHP_DOCKER_EXTENSIONS="pdo pdo_mysql intl opcache zip gd sockets"
ARG PHP_PECL_EXTENSIONS="redis"

# App Root Path relative to context
ARG HOST_APP_ROOT_DIR="./codes/"
ARG WORK_DIR_PATH="/var/www/html"

# Proxy
ENV http_proxy="${HTTP_PROXY}" \
    https_proxy="${HTTPS_PROXY}" \
    no_proxy="${NO_PROXY}"

# Timezone
ENV TZ="${TIMEZONE}"

USER root

RUN echo "-- Configure Timezone --" \
        && echo "${TIMEZONE}" > /etc/timezone \
        && rm /etc/localtime \
        && dpkg-reconfigure -f noninteractive tzdata \
    && echo "-- Configure NGINX --" \
        && apt-get update -y \
        && apt-get install -y --no-install-recommends curl gnupg2 ca-certificates lsb-release \
        && echo "deb http://nginx.org/packages/mainline/debian `lsb_release -cs` nginx" \
            | tee /etc/apt/sources.list.d/nginx.list \
        && curl -fsSL https://nginx.org/keys/nginx_signing.key | apt-key add - \
    && echo "-- Install Dependencies --" \
        && apt-get update -y \
        && apt-get install -y --no-install-recommends ${APT_DEPENDENCIES} \
    && echo "-- Cleanup Junks --" \
        && apt-get autoremove -y \
        && apt-get clean -y \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
        && rm /usr/local/etc/php-fpm.d/zz-docker.conf | true

# PHP Extensions Installation
RUN if [ ! -z "${HTTP_PROXY}" ]; then \
        pear config-set http_proxy "${HTTP_PROXY}" \
    ;fi \
    && pear update-channels \
    && pear upgrade \
    && docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-configure intl \
    && docker-php-ext-install ${PHP_DOCKER_EXTENSIONS} \
    && pecl install ${PHP_PECL_EXTENSIONS} \
    && docker-php-ext-enable ${PHP_PECL_EXTENSIONS} \
    && pear clear-cache

# Make Self-Signed SSL if not Cert Files found
COPY ./docker/web-app/nginx/certs/* /etc/ssl/certs/
RUN if [ ! -f /etc/ssl/certs/default.crt ]; then \
        openssl genrsa -out "/etc/ssl/certs/default.key" 2048 && \
        openssl req -new -key "/etc/ssl/certs/default.key" -out "/etc/ssl/certs/default.csr" -subj "/CN=default/O=default/C=UK" && \
        openssl x509 -req -days 365 -in "/etc/ssl/certs/default.csr" -signkey "/etc/ssl/certs/default.key" -out "/etc/ssl/certs/default.crt" \
    ;fi

# PHP Composer Installation & Directory Permissions
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && mkdir -p /var/www/.composer \
    && mkdir /run/php \
    && chown -R www-data:www-data /var/www/.composer /run/php \
    && chmod -R ug+sw /var/www/.composer

COPY ./docker/web-app/php-fpm/php.ini /usr/local/etc/php/conf.d/app-php.ini

# PHP INIT Settings for production by default
# error_reporting
#   32767 = E_ALL
#   22519 = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT
ENV PHP_INI_OUTPUT_BUFFERING="4096" \
    PHP_INI_ZLIB_OUTPUT_COMPRESSION="Off" \
    PHP_INI_EXPOSE_PHP="Off" \
    PHP_INI_MAX_EXECUTION_TIME="60" \
    PHP_INI_MAX_INPUT_TIME="60" \
    PHP_INI_MEMORY_LIMIT="256M" \
    PHP_INI_ERROR_REPORTING=32767 \
    PHP_INI_DISPLAY_ERRORS="Off" \
    PHP_INI_DISPLAY_STARTUP_ERRORS="Off" \
    PHP_INI_ERROR_LOG="${WORK_DIR_PATH}/storage/logs/php_errors.log" \
    PHP_INI_LOG_ERRORS="On" \
    PHP_INI_LOG_ERRORS_MAX_LEN="1024" \
    PHP_INI_POST_MAX_SIZE="2M" \
    PHP_INI_FILE_UPLOADS="On" \
    PHP_INI_UPLOAD_MAX_FILESIZE="2M" \
    PHP_INI_MAX_FILE_UPLOADS="2" \
    PHP_INI_ALLOW_URL_FOPEN="On" \
    PHP_INI_DATE_TIMEZONE="${TIMEZONE}" \
    PHP_INI_SESSION_SAVE_HANDLER="files" \
    PHP_INI_SESSION_SAVE_PATH="/tmp" \
    PHP_INI_SESSION_USE_STRICT_MODE="0" \
    PHP_INI_SESSION_USE_COOKIES="1" \
    PHP_INI_SESSION_USE_ONLY_COOKIES="1" \
    PHP_INI_SESSION_NAME="APP_SSID" \
    PHP_INI_SESSION_COOKIE_SECURE="On" \
    PHP_INI_SESSION_COOKIE_LIFETIME="0" \
    PHP_INI_SESSION_COOKIE_PATH="/" \
    PHP_INI_SESSION_COOKIE_DOMAIN="" \
    PHP_INI_SESSION_COOKIE_HTTPONLY="On" \
    PHP_INI_SESSION_COOKIE_SAMESITE="" \
    PHP_INI_SESSION_UPLOAD_PROGRESS_NAME="APP_UPLOAD_PROGRESS" \
    PHP_INI_OPCACHE_ENABLE="1" \
    PHP_INI_OPCACHE_ENABLE_CLI="0" \
    PHP_INI_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_INI_OPCACHE_INTERNED_STRINGS_BUFFER="16" \
    PHP_INI_OPCACHE_MAX_ACCELERATED_FILES="100000" \
    PHP_INI_OPCACHE_MAX_WASTED_PERCENTAGE="25" \
    PHP_INI_OPCACHE_USE_CWD="0" \
    PHP_INI_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_INI_OPCACHE_REVALIDATE_FREQ="0" \
    PHP_INI_OPCACHE_SAVE_COMMENTS="0" \
    PHP_INI_OPCACHE_ENABLE_FILE_OVERRIDE="1" \
    PHP_INI_OPCACHE_MAX_FILE_SIZE="0" \
    PHP_INI_OPCACHE_FAST_SHUTDOWN="1"

WORKDIR ${WORK_DIR_PATH}

USER www-data

# Composer Packages Installation
COPY --chown=www-data:www-data ${HOST_APP_ROOT_DIR}composer.* ${WORK_DIR_PATH}/
RUN composer global require hirak/prestissimo \
    && composerInstallArgs="--no-scripts --no-interaction --no-autoloader" \
    && export composerInstallArgs \
    && if [ ${BUILD_MODE} = "prod" ]; then \
        composerInstallArgs="$composerInstallArgs --no-dev" \
        && export composerInstallArgs \
    ;fi \
    && composer install $composerInstallArgs \
    && composer clear-cache

# App ENV Settings
ENV DEBUGBAR_ENABLED=false \
    APP_NAME="Laravel" \
    APP_ENV="production" \
    APP_KEY="" \
    APP_DEBUG=false \
    APP_SERVER_NAME="localhost" \
    APP_SERVER_PORT=443 \
    APP_URL="https://localhost/" \
    APP_PUBLIC_PATH="/public" \
    APP_TIMEZONE="${TIMEZONE}" \
    LOG_CHANNEL="stack" \
    DB_CONNECTION="mysql" \
    DB_HOST="db" \
    DB_PORT=3306 \
    DB_DATABASE="db_name" \
    DB_USERNAME="db_user" \
    DB_PASSWORD="db_password" \
    DB_TIMEZONE="+00:00" \
    DB_USE_DEFAULT_STRING_LENGTH=false \
    BROADCAST_DRIVER="log" \
    CACHE_DRIVER="file" \
    QUEUE_CONNECTION="sync" \
    SESSION_DRIVER="file" \
    SESSION_LIFETIME=120 \
    ECHO_API_APP_ID="" \
    ECHO_API_KEY="" \
    REDIS_HOST="redis" \
    REDIS_PASSWORD=null \
    REDIS_PORT=6379 \
    REDIS_DB=0 \
    REDIS_CACHE_DB=1 \
    MAIL_DRIVER="smtp" \
    MAIL_HOST="smtp.mailtrap.io" \
    MAIL_PORT=2525 \
    MAIL_USERNAME=null \
    MAIL_PASSWORD=null \
    MAIL_ENCRYPTION=null \
    FIREBASE_API_ACCESS_KEY="" \
    FIREBASE_SSL_VERIFY=false

# Composer DumpAutoload
COPY --chown=www-data:www-data ${HOST_APP_ROOT_DIR} ${WORK_DIR_PATH}
RUN composerDumpAutoloadArgs="--optimize" \
    && export composerDumpAutoloadArgs \
    && if [ ${BUILD_MODE} = "prod" ]; then \
        composerDumpAutoloadArgs="$composerDumpAutoloadArgs --classmap-authoritative" \
        && export composerDumpAutoloadArgs \
    ;fi \
    && composer dump-autoload $composerDumpAutoloadArgs

USER root

RUN chmod -R ug+w bootstrap/cache/ storage/

COPY ./docker/web-app/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./docker/web-app/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/web-app/nginx/vhost.conf /etc/nginx/conf.d/default.conf
COPY ./docker/web-app/supervisor/supervisord.conf /etc/supervisor/
COPY ./docker/web-app/supervisor/conf.d/* /etc/supervisor/conf.d/

EXPOSE 443

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
