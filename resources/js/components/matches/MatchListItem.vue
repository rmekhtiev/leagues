<template>
    <div>
        <div>
            <div v-if="match.status === 'live'" class="d-flex align-center">
                <v-icon color="error">mdi-circle-small</v-icon>
                <span>LIVE</span>
            </div>
        </div>
        <v-row no-gutters>
            <v-col cols="4" class="black--text">
                <div>{{ match.home_team.title }}</div>
            </v-col>
            <v-col cols="4" class="text-center">
                <div v-if="match.status !== 'upcoming'">
                    <span :class="`${scoreColor.home}--text`">{{
                        match.home_team_score
                    }}</span>
                    -
                    <span :class="`${scoreColor.away}--text`">{{
                        match.away_team_score
                    }}</span>
                </div>
                <div v-else>-:-</div>
            </v-col>
            <v-col cols="4" class="text-right black--text">{{
                match.away_team.title
            }}</v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "MatchListItem",
    props: {
        match: {
            type: Object,
            required: true,
            default: () => ({}),
        },
    },
    computed: {
        scoreColor() {
            return {
                home:
                    this.match.home_team_score > this.match.away_team_score
                        ? "green"
                        : "red",
                away:
                    this.match.away_team_score > this.match.home_team_score
                        ? "green"
                        : "red",
            };
        },
    },
};
</script>

<style scoped></style>
