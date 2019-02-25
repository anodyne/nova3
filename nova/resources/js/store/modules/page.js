import { make } from 'vuex-pathify';

const moduleState = {};

export default {
    namespaced: true,
    state: moduleState,
    mutations: {
        ...make.mutations(moduleState)
    }
};
