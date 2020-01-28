import Vue from 'vue';

Vue.config.productionTip = false;

/* eslint-disable */
Vue.prototype.$route = window.route;
Vue.prototype.$events = new Vue();
/* eslint-enable */
