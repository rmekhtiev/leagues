<template>
    <v-container v-if="league">
        <v-row no-gutters class="mb-4">
            <v-col col="12">
                <league-info-card
                    :league="league"
                    @reset="onReset"
                    @simulated="onSimulate"
                />
            </v-col>
        </v-row>
        <div v-if="week">
            <v-row no-gutters class="mb-4">
                <v-col cols="12" lg="6" md="12" class="px-2 mb-lg-0 mb-4">
                    <league-teams-card :league="league" :week="week" />
                </v-col>
                <v-col cols="12" lg="6" md="12" class="px-2">
                    <league-matches-results-card
                        :week="week"
                        :league="league"
                        @weekChanged="(value) => weekChanged(value)"
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

export default {
    name: "LeagueHome",
    components: { LeagueMatchesResultsCard, LeagueTeamsCard, LeagueInfoCard },
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
    },
};
</script>

<style scoped></style>
