import { make } from 'vuex-pathify';

const moduleState = {};

const mutations = {
    ...make.mutations(moduleState),

    initialUser (state, data) {
        Object.assign(state, data);
    }
};

const actions = {
    setInitialUser ({ commit }, data) {
        commit('initialUser', data);
    }
};

export default {
    namespaced: true,
    state: moduleState,
    mutations,
    actions
};
