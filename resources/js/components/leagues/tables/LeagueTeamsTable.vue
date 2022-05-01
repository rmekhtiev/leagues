<template>
    <div>
        <v-data-table
            disable-pagination
            hide-default-footer
            :headers="headers"
            :items="items"
        >
            <template #item.place="{ index }">
                {{ index + 1 }}
            </template>
        </v-data-table>
    </div>
</template>

<script>
export default {
    name: "LeagueTeamsTable",
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
            headers: [
                {
                    text: "Place",
                    sortable: false,
                    align: "start",
                    value: "place",
                },
                {
                    text: "Teams",
                    sortable: false,
                    align: "start",
                    value: "team.title",
                },
                {
                    text: "Points",
                    sortable: false,
                    align: "start",
                    value: "points",
                },
                {
                    text: "W",
                    sortable: false,
                    align: "start",
                    value: "wins",
                },
                {
                    text: "D",
                    sortable: false,
                    align: "start",
                    value: "draws",
                },
                {
                    text: "L",
                    sortable: false,
                    align: "start",
                    value: "loses",
                },
                {
                    text: "GD",
                    sortable: false,
                    align: "start",
                    value: "goal_diff",
                },
            ],
            items: [],
        };
    },
    watch: {
        week() {
            this.loadStats();
        },
    },
    mounted() {
        this.loadStats();
    },
    methods: {
        async loadStats() {
            const response = await this.$axios.get(
                `leagues/${this.league.id}/stats`,
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
