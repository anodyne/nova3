import Vue from 'vue';

const files = require.context('./', true, /\.vue$/i);

const excludedComponents = [
    //
];

files.keys()
    .filter((file) => {
        return excludedComponents.indexOf(file) === -1;
    })
    .map((key) => {
        Vue.component(key.split('/').pop().split('.')[0], files(key).default);

        return true;
    });
