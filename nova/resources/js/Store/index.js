import Vue from 'vue';
import Vuex from 'vuex';
import pathify from './pathify';

import Page from './modules/page';
import User from './modules/user';
import Icons from './modules/icons';
import Theme from './modules/theme';
import Settings from './modules/settings';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Page,
        User,
        Icons,
        Theme,
        Settings
    },

    plugins: [pathify.plugin]
});
