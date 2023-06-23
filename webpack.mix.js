const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath('./');
/*
mix.js('resources/js/app.js', 'public/js').version();
mix.js('resources/js/show.js', 'public/js').version();
mix.js('resources/js/edit-bulk.js', 'public/js').version();
*/
mix.copyDirectory('resources/js', 'public/js');
mix.sass('resources/scss/app.scss', 'public/css').version();

mix.copyDirectory('resources/i', 'public/i');
mix.copyDirectory('resources/tinymce', 'public/tinymce');
