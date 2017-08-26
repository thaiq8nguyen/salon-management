const { mix } = require('laravel-mix');
const webpack = require('webpack');
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
    mix.webpackConfig({
        plugins: [
        // reduce bundle size by ignoring moment js local files
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    ]
    });
    mix.js(['resources/assets/js/home.js'], 'public/js')
        .js(['resources/assets/js/salon-sales.js'], 'public/js')
        .js(['resources/assets/js/create-sales.js'], 'public/js/technicians')
        .js(['resources/assets/js/api-dashboard.js'], 'public/js')
        .js(['resources/assets/js/payday.js'], 'public/js/salon')
        .js(['resources/assets/js/quick-sale-entry.js'], 'public/js/salon')
        .js(['resources/assets/js/salon/gift-certificate.js'], 'public/js/salon')
        .js(['resources/assets/js/technician/technician.js'],'public/js/technicians')
        .js(['resources/assets/js/technician/technician-sale.js'], 'public/js/technicians');






    //mix.browserSync('shop-management.dev');

   /*.sass('resources/assets/sass/app.scss', 'public/css');*/
