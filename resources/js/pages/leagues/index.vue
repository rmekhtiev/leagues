<template>
    <div>
        <v-container>
            <v-card class="elevation-1 rounded-lg px-5 py-7">
                <v-row>
                    <v-col>
                        <leagues-table />
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
    </div>
</template>

<script>
import LeaguesTable from "@/components/leagues/LeaguesTable";
export default {
    name: "AppLeaguesIndexPage",
    components: {
        LeaguesTable,
    },
};
</script>
