import Vue from 'vue';

require.context('./', true, /\.vue$/i, 'lazy')
    .keys()
    .forEach((file) => {
        Vue.component(file.split('/').pop().split('.')[0], (resolve) => {
            import(`${file}`  /* webpackChunkName: "[request]" */)
                .then((component) => {
                    resolve(component.default);
                });
        });
    });