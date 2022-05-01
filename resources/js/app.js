require("./bootstrap");

import Vue from "vue";
import Vuetify from "./plugins/vuetify";
import Root from "./Root";

import router from "./routes";
import transport from "./plugins/axios";
import store from "./store";
import axiosHandlers from "./plugins/axiosHandler";
import Toasted from "vue-toasted";
import moment from "moment";
import "./filters/formatDate";

Vue.use(transport);
Vue.use(Toasted);

Vue.prototype.$moment = moment;
Vue.prototype.$axios = transport;

new Vue({
    el: "#app",
    vuetify: Vuetify,
    router: router,
    store: store,
    axiosHandlers,
    components: {
        Root,
    },
});
