<template>
    <v-card>
        <v-card-title>
            <div class="d-flex w-full justify-space-between align-center">
                <div class="overline">Match Results</div>
                <div style="width: 75px">
                    <v-select
                        :value="week"
                        label="Week"
                        hide-details
                        :items="
                            Array.from(
                                { length: league.weeks },
                                (v, k) => k + 1
                            )
                        "
                        dense
                        @change="(value) => weekChanged(value)"
                    ></v-select>
                </div>
            </div>
        </v-card-title>
        <v-card-text class="py-4">
            <MatchListItem
                v-for="(item, index) in items"
                :key="`match-${index}`"
                :match="item"
                class="mb-2 body-1"
            />
        </v-card-text>
    </v-card>
</template>

<script>
import MatchListItem from "@/components/matches/MatchListItem";
import editableTableData from "@/mixins/editableTableData";
import serverSidePagination from "@/mixins/serverSidePagination";

export default {
    name: "LeagueMatchesResultsCard",
    components: { MatchListItem },
    mixins: [editableTableData, serverSidePagination],
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
            resource: "matches",
            filter: {
                league_id: this.league.id,
                by_week: this.week,
            },
        };
    },
    watch: {
        week() {
            this.filter.by_week = this.week;
            this.loadResource();
        },
    },
    mounted() {
        this.loadResource();
    },
    methods: {
        weekChanged(week) {
            this.$emit("weekChanged", week);
        },
    },
};
</script>

<style scoped></style>
