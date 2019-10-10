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

mix.sass('resources/sass/categories.scss', 'public/css')
.sass('resources/sass/forum_layout.scss', 'public/css')
.sass('resources/sass/home.scss', 'public/css')
.sass('resources/sass/category.scss', 'public/css');