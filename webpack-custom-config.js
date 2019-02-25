const path = require('path');

module.exports = {
    output: {
        chunkFilename: 'js/[name].[contenthash].js',
        publicPath: '/dist/'
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './nova/resources/js/'),
            '@node_modules': path.resolve(__dirname, './node_modules/')
            // vue$: 'vue/dist/vue.runtime.js'
        },
        symlinks: false
    }
};
