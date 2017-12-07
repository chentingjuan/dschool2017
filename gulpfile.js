const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
require('laravel-elixir-webpack-official')
require('laravel-blade-jade');
var path = require("path");
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

// const PrerenderSpaPlugin = require('prerender-spa-plugin')
// elixir.webpack.mergeConfig({
//     plugins: [
//         // new webpack.ProvidePlugin({
//         //     $: 'jquery',
//         //     jQuery: 'jquery',
//         //     'window.jQuery': 'jquery',
//         // }),
//         new PrerenderSpaPlugin(
//             // Path to compiled app
//             path.join(__dirname, '../public'),
//             // List of endpoints you wish to prerender
//             ['/', '/about', '/activity', '/news', '/implement', '/service', '/question']
//         )
//     ]
// });

elixir((mix) => {

    //https://vuejs-templates.github.io/webpack/prerender.html


    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/bootstrap')
       .sass('app.sass')
       .webpack([
          './node_modules/babel-polyfill/dist/polyfill.js',
          'app.js'
        ],'public/js/app.js')
    //    .webpack([
    //       'manage/app.js'
    //     ],'public/js/backstage/app.js')
    //    .jade({
    //     baseDir: './resources',
    //     blade: true,
    //     dest: '/views/',
    //     pretty: true,
    //     search: '**/*.jade',
    //     src: '/blade/'
    // });

});
