<template>
    <v-card>
        <v-card-title class="overline"
            >{{ weekWithSuffix }} Week Predictions of Championship
            after</v-card-title
        >
        <v-card-text>
            <team-championship-prediction-list-item
                v-for="(item, index) in items"
                :key="`prediction-${index}`"
                :prediction="item"
                class="mb-2"
            />
        </v-card-text>
    </v-card>
</template>

<script>
import ordinalSuffix from "@/mixins/ordinalSuffix";
import TeamChampionshipPredictionListItem from "@/components/teams/TeamChampionshipPredictionListItem";

export default {
    name: "LeagueWinnerPredictionCard",
    components: { TeamChampionshipPredictionListItem },
    mixins: [ordinalSuffix],
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
    data() {
        return {
            items: [],
        };
    },
    computed: {
        weekWithSuffix() {
            return this.ordinalSuffix(this.week);
        },
    },
    watch: {
        week() {
            this.loadPredictions();
        },
    },
    mounted() {
        this.loadPredictions();
    },
    methods: {
        async loadPredictions() {
            const response = await this.$axios.get(
                `leagues/${this.league.id}/predictions`,
                {
                    params: {
                        week: this.week,
                    },
                }
            );
            this.items = response.data.data;
        },
    },
};
</script>

<style scoped></style>
