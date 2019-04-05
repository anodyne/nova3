import { make } from 'vuex-pathify';

const moduleState = {};

const mutations = {
    ...make.mutations(moduleState),

    initialIcons (state, data) {
        state = Object.assign(state, data);
    }
};

const actions = {
    setInitialIcons ({ commit }, data) {
        commit('initialIcons', data);
    }
};

export default {
    namespaced: true,
    state: moduleState,
    mutations,
    actions
};
