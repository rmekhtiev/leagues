import Vue from "vue";
import Vuex from "vuex";
import { state, actions, mutations, getters } from "./rootModule";
import { resourceModule } from "@reststate/vuex";
import transport from "@/plugins/axios";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: state,
    actions: actions,
    mutations: mutations,
    getters: getters,
    modules: {
        leagues: resourceModule({ name: "leagues", httpClient: transport }),
        matches: resourceModule({ name: "matches", httpClient: transport }),
    },
});

export default store;
