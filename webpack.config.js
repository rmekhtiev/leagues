// This file is not used in app build
// Just for IDE

const path = require("path");

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
};
