import Vue from 'vue';

// Vue.component('nova-app', require('./components/NovaApp').default);

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