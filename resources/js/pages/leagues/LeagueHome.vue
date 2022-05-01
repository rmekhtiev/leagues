<template>
    <div v-if="league">
        <LeagueInfoCard :league="league" />
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import LeagueInfoCard from "@/components/leagues/cards/LeagueInfoCard";

export default {
    name: "LeagueHome",
    components: { LeagueInfoCard },
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
    },

    methods: {
        ...mapActions({
            loadLeague: "leagues/loadById",
        }),
        loadResource() {
            return this.loadLeague({ id: this.leagueId });
        },
    },
};
</script>

<style scoped></style>
