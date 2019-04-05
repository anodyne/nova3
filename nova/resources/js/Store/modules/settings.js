import { make } from 'vuex-pathify';

const moduleState = {};

const mutations = {
    ...make.mutations(moduleState),

    initialSettings (state, data) {
        Object.assign(state, data);
    }
};

const actions = {
    setInitialSettings ({ commit }, data) {
        commit('initialSettings', data);
    }
};

export default {
    namespaced: true,
    state: moduleState,
    mutations,
    actions
};
