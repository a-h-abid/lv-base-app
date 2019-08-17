const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.options({
        processCssUrls: false
    })

    /**
     * Use only for copying once, then disable it
     * As files will be available with git
     */
    // .copyDirectory(
    //     'node_modules/@fortawesome/fontawesome-free/webfonts',
    //     'public/assets/shared/fonts/vendor/@fortawesome/fontawesome-free'
    // )

    .sass('resources/assets/admin/sass/admin.scss', 'public/assets/admin/css')
    .js('resources/assets/admin/js/admin.js', 'public/assets/admin/js')

    // .js('resources/assets/app/js/app.js', 'public/assets/app/js')
    // .sass('resources/assets/app/sass/app.scss', 'public/assets/app/css')
    ;
