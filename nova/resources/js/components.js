import Vue from 'vue';

const files = require.context('./', true, /\.vue$/i);

const excludedComponents = [
    './plugins/popover/Popover.vue'
];

files.keys()
    .filter((file) => {
        return excludedComponents.indexOf(file) === -1;
    })
    .map((key) => {
        Vue.component(key.split('/').pop().split('.')[0], files(key));

        return true;
    });
