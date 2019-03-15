import Vue from 'vue';
import './plugins/font-awesome';
import Toast from 'buefy/dist/components/toast';

Vue.use(Toast);

Vue.mixin({
    methods: {
        route
    }
});
