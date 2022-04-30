export default {
    data: () => ({
        dialog: false,
        activeId: -1,
        itemsLoading: true,
        footerProps: {
            "items-per-page-options": [10, 15, 30],
            itemsPerPageText: "Elements per page",
        },
    }),

    computed: {
        formTitle() {
            return this.activeId === "-1" ? "Создать" : "Правка";
        },

        items() {
            return this.$store.getters[this.resource + "/where"](
                this.serverPayload
            );
        },
        axiosConfig() {
            if (this.activeId === "-1") {
                return {
                    url: "/" + this.resource,
                    method: "post",
                };
            } else
                return {
                    url: "/" + this.resource + "/" + this.modalItem.id,
                    method: "put",
                };
        },
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
    },

    methods: {
        loadResource() {
            this.itemsLoading = true;
            this.$store
                .dispatch(this.resource + "/loadWhere", this.serverPayload)
                .then(() => (this.itemsLoading = false));
        },

        editItem(item) {
            this.activeId = item.id;
            this.modalItem = Object.assign({}, item);
            this.dialog = true;
        },

        async deleteItem(item) {
            this.activeId = item.id;
            this.$axios
                .delete("/" + this.resource + "/" + this.activeId)
                .then(() => {
                    this.loadResource();
                    this.$emit("delete");
                })
                .catch(function (e) {
                    console.error(e);
                });

            this.close();
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.modalItem = {};
                this.activeId = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.activeId = -1;
        },

        async save() {
            this.$axios({
                method: this.axiosConfig.method,
                url: this.axiosConfig.url,
                data: this.modalItem,
            })
                .then(() => {
                    this.loadResource();
                })
                .catch(function (e) {
                    console.log(e);
                });

            this.close();
        },

        clearSearch() {
            delete this.filter.search;
            this.loadResource();
        },
    },
};
