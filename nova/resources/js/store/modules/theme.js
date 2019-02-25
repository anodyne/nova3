import { make } from 'vuex-pathify';

const moduleState = {};

const mutations = {
    ...make.mutations(moduleState),

    initialTheme (state, data) {
        state = Object.assign(state, data);
    }
};

const actions = {
    setInitialTheme ({ commit }, data) {
        commit('initialTheme', data);
    }
};

export default {
    namespaced: true,
    state: moduleState,
    mutations,
    actions
};
