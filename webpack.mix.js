const mix = require('laravel-mix');

// Add this at the top to configure production settings
if (mix.inProduction()) {
    mix.options({
        terser: {
            extractComments: false,
        },
        devtool: false,
        sourceMaps: false
    });
}

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

// front
// If you wish to modify the template's SCSS or JS, please change 'theme' to the directory where your current theme is located.
const theme = '';
if (theme === '') {
  mix.sass('innopacks/front/resources/css/bootstrap/bootstrap.scss', 'public/build/front/css/bootstrap.css');
  mix.sass('innopacks/front/resources/css/app.scss', 'public/build/front/css/app.css');
  mix.js('innopacks/front/resources/js/app.js', 'public/build/front/js/app.js');
} else {
  mix.sass('themes/' + theme + '/css/bootstrap/bootstrap.scss', 'public/static/themes/' + theme + '/css/bootstrap.css');
  mix.sass('themes/' + theme + '/css/app.scss', 'public/static/themes/' + theme + '/css/app.css');
  mix.js('themes/' + theme + '/js/app.js', 'public/static/themes/' + theme + '/js/app.js');
}


// panel - remove sourceMaps for production
mix.sass('innopacks/panel/resources/css/bootstrap/bootstrap.scss', 'public/build/panel/css/bootstrap.css');
mix.sass('innopacks/panel/resources/css/app.scss', 'public/build/panel/css/app.css');
mix.js('innopacks/panel/resources/js/app.js', 'public/build/panel/js/app.js');

// install
mix.sass('innopacks/install/resources/css/app.scss', 'public/build/install/css/app.css');

// Remove sourceMaps() from this section for production
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .version();

// Keep your jQuery autoload
mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    'popper.js/dist/umd/popper.js': ['Popper']
});
