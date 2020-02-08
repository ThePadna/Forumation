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
.sass('resources/sass/category.scss', 'public/css')
.sass('resources/sass/post.scss', 'public/css')
.sass('resources/sass/thread.scss', 'public/css')
.sass('resources/sass/profile.scss', 'public/css')
.sass('resources/sass/edit.scss', 'public/css')
.sass('resources/sass/admin.scss', 'public/css')
.js('resources/js/admin.js','public/js/admin.js')
.js('resources/js/categories.js', 'public/js/categories.js')
.js('resources/js/profile_edit.js', 'public/js/profile_edit.js')
.js('resources/js/profile', 'public/js/profile.js')
.js('resources/js/thread.js', 'public/js/thread.js')
.js('resources/js/category.js', 'public/js/category.js');