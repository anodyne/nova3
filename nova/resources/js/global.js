import Vue from 'vue';

Vue.config.productionTip = false;
Vue.mixin({
    methods: {
        route: window.route
    }
});
