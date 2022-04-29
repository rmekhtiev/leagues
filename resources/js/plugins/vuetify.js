import Vue from "vue";
import Vuetify from "vuetify";
import ru from "vuetify/lib/locale/ru";

Vue.use(Vuetify);

const options = {
    lang: {
        locales: { ru },
        current: "ru",
    },
    theme: {
        themes: {
            light: {
                primary: "#2E4EA4",
            },
        },
    },
};

export default new Vuetify(options);
