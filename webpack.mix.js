let mix = require('laravel-mix').vue({ version: 2});

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

mix.options({ processCssUrls: false })
    .js('resources/js/scripts.js', 'public/js')
    .less('resources/less/styles.less', 'css/styles.css');

if (mix.inProduction()) {
    mix.version()
        .sourceMaps()
        .webpackConfig({
            plugins: [
                new BugsnagSourceMapUploaderPlugin({
                    apiKey: 'e6dafe167baecf4f0cd93ba2ac4fc986',
                    publicPath: 'https://dgtournaments.com/',
                    appVersion: 'current',
                    overwrite: true
                })
            ]
        });
}
