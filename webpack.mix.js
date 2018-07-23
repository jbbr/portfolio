const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').version();
mix.less('resources/assets/less/app.less', 'public/css/')
    .options({
        processCssUrls: false
    }).version();

/** tinymce - copy assets */
mix.copy('node_modules/tinymce/skins', 'public/tinymce/skins', false);
mix.copy('node_modules/tinymce/themes', 'public/tinymce/themes', false);

/** there is no option to set the plugin_url... */
mix.copy('node_modules/tinymce/plugins', 'public/js/plugins', false);