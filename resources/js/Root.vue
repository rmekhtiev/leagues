<template>
    <v-app id="inspire">
        <TheDrawer />
        <v-main>
            <v-container fluid>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import TheDrawer from "./components/TheDrawer";

export default {
    name: "AppRoot",
    components: { TheDrawer },
    data: () => ({ drawer: null }),
};
</script>
