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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .js('resources/js/Errors.js', 'public/js')
    .css('resources/css/screen.css', 'public/css')
    .css('resources/css/layout.css', 'public/css')
    .css('resources/css/landing.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .css('resources/css/login.css', 'public/css');
