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

mix.sass('resources/sass/forum/categories.scss', 'public/css')
.sass('resources/sass/forum/forum_layout.scss', 'public/css')
.sass('resources/sass/forum/category.scss', 'public/css')
.sass('resources/sass/forum/post.scss', 'public/css')
.sass('resources/sass/forum/thread.scss', 'public/css')
.sass('resources/sass/forum/profile.scss', 'public/css')
.sass('resources/sass/forum/edit.scss', 'public/css')
.sass('resources/sass/admin/admin.scss', 'public/css')
.sass('resources/sass/admin/datamanagement.scss', 'public/css')
.sass('resources/sass/admin/users.scss', 'public/css')
.sass('resources/sass/admin/posts.scss', 'public/css')
.sass('resources/sass/admin/threads.scss', 'public/css')
.sass('resources/sass/admin/ranks.scss', 'public/css')
.sass('resources/sass/forum/messages.scss', 'public/css')
.js('resources/js/admin/admin.js','public/js/admin.js')
.js('resources/js/forum/forum_layout.js','public/js/forum_layout.js')
.js('resources/js/forum/categories.js', 'public/js/categories.js')
.js('resources/js/forum/messages.js', 'public/js/messages.js')
.js('resources/js/forum/profile_edit.js', 'public/js/profile_edit.js')
.js('resources/js/forum/thread.js', 'public/js/thread.js')
.js('resources/js/forum/category.js', 'public/js/category.js')
.js('resources/js/admin/datamanagement.js', 'public/js/datamanagement.js')
.js('resources/js/admin/users.js', 'public/js/users.js')
.js('resources/js/admin/threads.js', 'public/js/threads.js')
.js('resources/js/admin/posts.js', 'public/js/posts.js')
.js('resources/js/admin/ranks.js', 'public/js/ranks.js')
.js('resources/js/forum/profile.js', 'public/js/profile.js');