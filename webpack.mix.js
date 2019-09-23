const mix = require("laravel-mix");
const path = require("path");
const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .webpackConfig({
        output: { chunkFilename: "js/[name].js?id=[chunkhash]" },
        resolve: {
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
                "@": path.resolve("resources/js")
            }
        },
        plugins: [new VuetifyLoaderPlugin()]
    })
    .version()
    .sourceMaps();
