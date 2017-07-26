const { mix } = require('laravel-mix');

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

    mix.js(['resources/assets/js/salon-sales.js'], 'public/js')
        .js(['resources/assets/js/create-sales.js'], 'public/js/technicians')
        .js(['resources/assets/js/api-dashboard.js'], 'public/js');

    mix.browserSync('shop-management.dev');

   /*.sass('resources/assets/sass/app.scss', 'public/css');*/
