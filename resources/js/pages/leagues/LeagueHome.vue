<template>
    <v-container v-if="league">
        <v-row no-gutters class="mb-4">
            <v-col col="12">
                <league-info-card
                    :league="league"
                    :week="week"
                    @reset="onReset"
                    @simulated="onSimulate"
                    @weekSimulated="onWeekSimulate"
                />
            </v-col>
        </v-row>
        <div v-if="week">
            <v-row no-gutters class="mb-4">
                <v-col cols="12" lg="6" md="12" class="px-2 mb-lg-0 mb-4">
                    <league-teams-card
                        ref="leagueTeamsCard"
                        :league="league"
                        :week="week"
                    />
                </v-col>
                <v-col cols="12" lg="6" md="12" class="px-2">
                    <league-matches-results-card
                        ref="leagueMatchesResultsCard"
                        :week="week"
                        :league="league"
                        class="mb-4"
                        @weekChanged="(value) => weekChanged(value)"
                    />
                    <league-winner-prediction-card
                        ref="leagueMatchesPredictionCard"
                        :week="week"
                        :league="league"
                    />
                </v-col>
            </v-row>
        </div>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import LeagueInfoCard from "@/components/leagues/cards/LeagueInfoCard";
import LeagueTeamsCard from "@/components/leagues/cards/LeagueTeamsCard";
import LeagueMatchesResultsCard from "@/components/leagues/cards/LeagueMatchesResultsCard";
import LeagueWinnerPredictionCard from "@/components/leagues/cards/LeagueWinnerPredictionCard";

export default {
    name: "LeagueHome",
    components: {
        LeagueWinnerPredictionCard,
        LeagueMatchesResultsCard,
        LeagueTeamsCard,
        LeagueInfoCard,
    },
    data() {
        return {
            week: null,
        };
    },
    computed: {
        ...mapGetters({
            leagueById: "leagues/byId",
        }),
        leagueId() {
            return this.$route.params.id;
        },
        league() {
            return this.leagueById({ id: this.leagueId });
        },
    },

    async mounted() {
        await this.loadResource();
        this.week = this.league.latest_playing_week;
    },

    methods: {
        ...mapActions({
            loadLeague: "leagues/loadById",
        }),
        weekChanged(week) {
            this.week = week;
        },
        loadResource() {
            return this.loadLeague({ id: this.leagueId });
        },
        onReset() {
            this.week = 1;
        },
        onSimulate() {
            this.week = this.league.weeks;
        },
        onWeekSimulate() {
            this.$refs.leagueTeamsCard.loadStats();
            this.$refs.leagueMatchesResultsCard.loadResource();
        },
    },
};
</script>

<style scoped></style>
