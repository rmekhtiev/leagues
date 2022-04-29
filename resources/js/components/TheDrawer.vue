<template>
    <div>
        <v-app-bar style="left: 0" app dark>
            <v-app-bar-nav-icon @click.native="drawer = !drawer" />
            <v-toolbar-title>Leagues</v-toolbar-title>

            <v-breadcrumbs :items="breadCrumbs" class="text--white">
                <template #item="{ item }">
                    <v-breadcrumbs-item
                        style="cursor: pointer"
                        :disabled="item.disabled"
                    >
                        <router-link
                            class="text--white text-uppercase cursor-pointer"
                            tag="div"
                            :to="item.href"
                            :class="{ disabled: item.disabled }"
                        >
                            {{ item.text }}
                        </router-link>
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
            <v-spacer></v-spacer>
        </v-app-bar>
        <v-navigation-drawer
            v-model="drawer"
            :class="{ [$style.miniWidth]: mini }"
            clipped
            left
            :mini-variant.sync="mini"
            app
            dark
        >
            <v-list class="relative" dense>
                <template v-for="(item, index) in items">
                    <v-list-item
                        v-if="item.to"
                        :key="index"
                        link
                        :to="{ name: item.to }"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{
                                item.name
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group
                        v-else
                        :key="index"
                        v-model="item.active"
                        :prepend-icon="item.icon"
                        color="white"
                    >
                        <template #activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.title" />
                            </v-list-item-content>
                        </template>

                        <template v-for="child in item.items">
                            <v-list-item
                                :key="child.name"
                                :to="{ name: child.to }"
                            >
                                <v-list-item-content>
                                    <v-list-item-title v-text="child.name" />
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </v-list-group>
                </template>
                <div
                    :class="{ [$style.button]: true, [$style.mini]: mini }"
                    @click="mini = !mini"
                >
                    <v-icon :class="{ 'mt-1 mr-2': mini, 'mt-3 ml-2': !mini }">
                        {{
                            mini ? "mdi-chevron-right" : "mdi-chevron-left"
                        }}</v-icon
                    >
                </div>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    data: () => ({
        drawer: true,
        mini: false,
        items: [
            {
                name: "Leagues",
                to: "leagues",
                icon: "mdi-account-outline",
            },
        ],
    }),
    computed: {
        breadCrumbs() {
            let pathArray = this.$route.path.split("/");

            pathArray.shift();

            let items = [];

            pathArray.forEach((item, index) => {
                let routerArray = this.$router.options.routes;

                let result;

                if (parseInt(item)) {
                    result = true;
                } else {
                    result = routerArray.find((obj) => {
                        return obj.name === item;
                    });
                }

                items.push({
                    text: item,
                    href: "/" + pathArray.slice(0, index + 1).join("/"),
                    disabled: !result,
                });
            });

            return items;
        },
    },
};
</script>

<style module>
.button {
    position: absolute;
    top: 50%;
    right: 0;
    width: 50px;
    height: 50px;
    margin-right: -20px;
    border-radius: 50%;
    background-color: #232323;
    cursor: pointer;
    transition: background-color ease-in-out 300ms, width ease-in-out 100ms;
}

.button:hover,
.button.mini:hover {
    background-color: #555;
}

.button.mini {
    width: 30px;
    height: 30px;
    margin-right: -10px;
    background-color: #363636;
}
.miniWidth {
    width: 66px !important;
}
</style>
