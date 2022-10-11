const mix = require('laravel-mix');
const webpack = require('webpack')
mix.webpackConfig({
    optimization: {
        splitChunks: {chunks: 'all'}
    },
    plugins: [
        // Ignore unnecessary package modules
        new webpack.IgnorePlugin({
            resourceRegExp: /^\.\/locale$/,
            contextRegExp: /moment$/,
        })
    ]
});

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
    .js('resources/js/src/main.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
