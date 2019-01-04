const path = require('path');

module.exports = {
    resolve: {
        symlinks: false,
        alias: {
            '@': path.resolve(__dirname, './nova/resources/js/'),
            '@node_modules': path.resolve(__dirname, './node_modules/')
        }
    }
};