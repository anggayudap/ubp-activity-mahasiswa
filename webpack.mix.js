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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.styles([
        /* VENDOR CSS */
        'public/vuexy/vendors/css/vendors.min.css',
        /* THEME CSS */
        'public/vuexy/css/bootstrap.css',
        'public/vuexy/css/bootstrap-extended.css',
        'public/vuexy/css/colors.css',
        'public/vuexy/css/components.css',
        'public/vuexy/css/themes/dark-layout.css',
        'public/vuexy/css/themes/bordered-layout.css',
        'public/vuexy/css/themes/semi-dark-layout.css',
        /* Page CSS */
        'public/vuexy/css/core/menu/menu-types/vertical-menu.css',

    ],
    'public/css/master_styles.css');

mix.scripts([
        /* VENDOR JS */
        'public/vuexy/vendors/js/vendors.min.js',
        /* THEME JS */
        'public/vuexy/js/core/app-menu.js',
        'public/vuexy/js/core/app.js',

    ],
    'public/js/master_scripts.js');

