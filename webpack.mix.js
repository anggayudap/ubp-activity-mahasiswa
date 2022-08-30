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
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.styles([
    // vendor css
    'public/vuexy/vendors/css/vendors.min.css',
    // theme css
    'public/vuexy/css/bootstrap.css',
    'public/vuexy/css/bootstrap-extended.css',
    'public/vuexy/css/colors.css',
    'public/vuexy/css/components.css',
    'public/vuexy/css/themes/dark-layout.css',
    'public/vuexy/css/themes/bordered-layout.css',
    'public/vuexy/css/themes/semi-dark-layout.css',
    'public/vuexy/css/core/menu/menu-types/vertical-menu.css',
    
    // common css
    'public/vuexy/vendors/css/animate/animate.min.css',
    'public/vuexy/vendors/css/extensions/sweetalert2.min.css',
],
    'public/css/hasil_combine.css');

mix.styles([
    // vendor css
    'public/vuexy/vendors/css/tables/datatable/dataTables.bootstrap4.min.css',
    'public/vuexy/vendors/css/tables/datatable/responsive.bootstrap4.min.css',
    'public/vuexy/vendors/css/tables/datatable/buttons.bootstrap4.min.css',
    'public/vuexy/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css',
],
    'public/css/table.css');

mix.styles([
    'public/vuexy/css/plugins/forms/form-validation.css',
    // datetime picker
    'public/vuexy/vendors/css/pickers/pickadate/pickadate.css',
    'public/vuexy/vendors/css/pickers/flatpickr/flatpickr.min.css',
    'public/vuexy/css/plugins/forms/pickers/form-flat-pickr.css',
    'public/vuexy/css/plugins/forms/pickers/form-pickadate.css',
    // select2
    'public/vuexy/vendors/css/forms/select/select2.min.css',
],
    'public/css/form.css');

mix.styles([
    
    'public/vuexy/css/pages/page-auth.css',
],
    'public/css/auth_styles.css');

mix.styles([
    'public/vuexy/css/pages/app-chat.css',
    'public/vuexy/css/pages/app-chat-list.css',
],
    'public/css/chat_styles.css');





mix.scripts([
    // vendor js
    'public/vuexy/vendors/js/vendors.min.js',
    // theme js
    'public/vuexy/js/core/app-menu.js',
    'public/vuexy/js/core/app.js',
    // common js
    'public/vuexy/vendors/js/extensions/sweetalert2.all.min.js',
    'public/vuexy/vendors/js/extensions/polyfill.min.js',
    'public/vuexy/vendors/js/ui/jquery.sticky.js',

],
    'public/js/hasil_combine.js');

mix.scripts([
    // vendor js
    'public/vuexy/vendors/js/tables/datatable/jquery.dataTables.min.js',
    'public/vuexy/vendors/js/tables/datatable/datatables.bootstrap4.min.js',
    'public/vuexy/vendors/js/tables/datatable/dataTables.responsive.min.js',
    'public/vuexy/vendors/js/tables/datatable/responsive.bootstrap4.js',
    'public/vuexy/vendors/js/tables/datatable/datatables.checkboxes.min.js',
    'public/vuexy/vendors/js/tables/datatable/datatables.buttons.min.js',
    'public/vuexy/vendors/js/tables/datatable/jszip.min.js',
    'public/vuexy/vendors/js/tables/datatable/pdfmake.min.js',
    'public/vuexy/vendors/js/tables/datatable/vfs_fonts.js',
    'public/vuexy/vendors/js/tables/datatable/buttons.html5.min.js',
    'public/vuexy/vendors/js/tables/datatable/buttons.print.min.js',
    'public/vuexy/vendors/js/tables/datatable/dataTables.rowGroup.min.js',
    'public/vuexy/vendors/js/pickers/flatpickr/flatpickr.min.js',
],
    'public/js/table.js');

mix.scripts([
    'public/vuexy/js/scripts/forms/form-validation.js',
    // cleave
    'public/vuexy/vendors/js/forms/cleave/cleave.min.js',
    'public/vuexy/vendors/js/forms/cleave/addons/cleave-phone.us.js',
        // jquery repeater
    'public/vuexy/vendors/js/forms/repeater/jquery.repeater.min.js',
    // datetime picker
    'public/vuexy/vendors/js/pickers/pickadate/picker.js',
    'public/vuexy/vendors/js/pickers/pickadate/picker.date.js',
    'public/vuexy/vendors/js/pickers/pickadate/picker.time.js',
    'public/vuexy/vendors/js/pickers/pickadate/legacy.js',
    'public/vuexy/vendors/js/pickers/flatpickr/flatpickr.min.js',
    /* select2 */
    'public/vuexy/vendors/js/forms/select/select2.full.min.js',
    /* input mask */
    'public/vuexy/js/scripts/forms/form-input-mask.js',
    /* jquery form validation */
    'public/vuexy/vendors/js/forms/validation/jquery.validate.min.js',

],
    'public/js/form.js');

mix.scripts([
    'public/vuexy/vendors/js/forms/validation/jquery.validate.min.js',
    'public/vuexy/vendors/js/ui/jquery.sticky.js',
    'public/vuexy/js/scripts/pages/page-auth-register.js',
    // 'public/vuexy/js/scripts/pages/page-auth-login.js',
],
    'public/js/auth_scripts.js');

mix.scripts([
    'public/vuexy/js/scripts/pages/app-chat.js',
],
    'public/js/chat_scripts.js');
