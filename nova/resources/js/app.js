import Inertia from 'inertia-vue';
import PortalVue from 'portal-vue';
import Vue from 'vue';

Vue.config.productionTip = false;
Vue.mixin({
    methods: {
        route: window.route
    }
});
Vue.use(PortalVue);

let app = document.getElementById('app');

new Vue({
    render(h) {
        return h(Inertia, {
            props: {
                component: app.dataset.component,
                props: JSON.parse(app.dataset.props),
                resolveComponent: (component) => {
                    return import(`@/pages/${component}`).then(module => module.default);
                }
            }
        })
    }
}).$mount(app);