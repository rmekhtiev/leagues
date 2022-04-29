import axios from "axios";

let config = {
    baseURL: "/api/v1",
    headers: {
        "Content-Type": "application/vnd.api+json",
    },
};

const transport = axios.create(config);
export default transport;
