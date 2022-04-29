import Vue from "vue";
import Vuex from "vuex";
import { state, actions, mutations, getters } from "./rootModule";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: state,
    actions: actions,
    mutations: mutations,
    getters: getters,
    modules: {},
});

export default store;
