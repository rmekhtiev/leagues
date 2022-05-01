<template>
    <v-card>
        <v-card-title class="overline">League Table</v-card-title>
        <v-card-text>
            <league-teams-table :league="league" :week="week" />
        </v-card-text>
    </v-card>
</template>

<script>
import LeagueTeamsTable from "@/components/leagues/tables/LeagueTeamsTable";
export default {
    name: "LeagueTeamsCard",
    components: { LeagueTeamsTable },
    props: {
        league: {
            type: Object,
            required: true,
            default: () => ({}),
        },
        week: {
            type: Number,
            required: false,
            default: 1,
        },
    },
};
</script>

<style scoped></style>
