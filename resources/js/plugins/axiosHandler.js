import Vue from "vue";
import transport from "./axios";
import router from "../routes";

const axiosHandlers = transport.interceptors.response.use(
    (response) => {
        if (response.status) {
            switch (response.status) {
                case 201:
                    Vue.toasted.success("Saved", {
                        duration: 3000,
                    });
                    break;
                case 202:
                    Vue.toasted.success("Saved", {
                        duration: 3000,
                    });
                    break;
                case 204:
                    Vue.toasted.success("Deleted", {
                        duration: 3000,
                    });
            }
            console.log(response.status);
            return Promise.resolve(response);
        } else {
            return Promise.reject(response);
        }
    },
    (error) => {
        console.error(error);
        if (error.response.status) {
            switch (error.response.status) {
                case 400:
                    Vue.toasted.error("Bad request", {
                        duration: 3000,
                    });
                    break;
                case 401:
                    Vue.toasted.error("Unauthenticated", {
                        duration: 3000,
                    });
                    break;
                case 403:
                    Vue.toasted.error("Forbidden", {
                        duration: 3000,
                    });
                    break;
                case 404:
                    Vue.toasted.error("Not found", {
                        duration: 3000,
                    });
                    router.push({ name: "404" });
                    break;
                case 405:
                    Vue.toasted.error("Not allowed", {
                        duration: 3000,
                    });
                    break;
                case 422:
                    Vue.toasted.error("Incorrect data", {
                        duration: 3000,
                    });
                    break;
                case 429:
                    Vue.toasted.error("Too many requests", {
                        duration: 3000,
                    });
                    break;
                case 500:
                    Vue.toasted.error("Server error", {
                        duration: 3000,
                    });
            }
            return Promise.reject(error.response);
        }
    }
);

export default axiosHandlers;
