#!/usr/bin/env bash

set -e

# Run our defined exec if args empty
if [ -z "$1" ]; then
    role=${CONTAINER_ROLE:-app}
    env=${APP_ENV:-production}

    echo "Role ::> $role" >> /proc/1/fd/1
    echo "App Env ::> $env" >> /proc/1/fd/1

    if [ "$env" != "local" ]; then
        echo "Caching configuration..." >> /proc/1/fd/1
        (cd /var/www/html && php artisan config:cache && php artisan event:cache && php artisan route:cache && php artisan view:cache)
    fi

    if [ "$role" = "app" ]; then

        echo "Running PHP-FPM..." >> /proc/1/fd/1
        exec php-fpm

    elif [ "$role" = "queue" ]; then

        echo "Running the queue..." >> /proc/1/fd/1
        php /var/www/html/artisan queue:work --verbose --tries=3 --timeout=90

    elif [ "$role" = "cron" ]; then

        echo "Running the cron..." >> /proc/1/fd/1
        while [ true ]
        do
        php /var/www/html/artisan schedule:run --verbose --no-interaction >> /proc/1/fd/1 &
        sleep 60
        done

    else
        echo "Could not match the container role \"$role\"" >> /proc/1/fd/2
        exit 1
    fi

else
    exec "$@"
fi
