import prepareData from "./prepareSortObject";

export default {
    data: () => ({
        paginatorOptions: {
            page: 1,
            itemsPerPage: 15,
            sortDesc: "",
        },
        filter: {},
    }),

    watch: {
        paginatorOptions: {
            handler: function () {
                prepareData(this.paginatorOptions);
                this.loadResource();
            },
            deep: true,
        },
    },

    computed: {
        serverPayload() {
            return {
                filter: this.filter,
                options: prepareData(this.paginatorOptions),
            };
        },
        totalItems() {
            return this.$store.getters[this.resource + "/lastMeta"]
                ? this.$store.getters[this.resource + "/lastMeta"].total
                : 0;
        },
    },
};
