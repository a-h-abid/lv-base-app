# Laravel Base/Skeleton App

Laravel Base/Skeleton App for quick start-up a project.

## Installation

### Docker Based Installation

*Todo...*


### Manual Installation

- Download the app
- Setup `.env` file from `.env.example`
    - In Development,
        - Set `APP_DEBUG` to **true**.
        - Set `APP_ENV` to **local**.
    - In Production,
        - Set `APP_DEBUG` to **false**.
        - Set `APP_ENV` to **production**.
- Run `composer install` (use `--no-dev` flag in production)
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed`

*Optional:*
- For Passport Usage, run `php artisan passport:install`. Keep the **password grant** client id and secret for API usage.

#### Setting up Queue

**For shared hosting**
- Setup cronjob using the following setting:
    - `* * * * * php /var/www/artisan schedule:run >> /dev/null 2>&1`

**For cloud/dedicated hosting**
- Start background queue process:
    - `nohup php /var/www/artisan queue:work --tries=3 &`

#### Web Server
- **Development**
    - Run `php artisan serve` or
    - Use your Apache/nGinX/LAMP/XAMPP server configuration
- **Production**
    - Use your Apache/nGinX server configuration


## License

MIT License.