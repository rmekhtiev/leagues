<template>
    <v-row no-gutters>
        <v-col
            v-if="league.poster_url"
            col="12"
            lg="4"
            class="px-2 d-flex flex-column justify-space-between"
        >
            <v-card class="h-full d-flex align-center"
                ><v-img :src="league.poster_url"
            /></v-card>
        </v-col>
        <v-col
            cols="12"
            :lg="league.poster_url ? '8' : null"
            class="d-flex align-center px-2"
        >
            <v-card class="w-full h-full mb-lg-0">
                <v-card-title>
                    {{ league.title }}
                </v-card-title>
                <!-- eslint-disable-next-line vue/no-v-html -->
                <v-card-subtitle v-html="league.description" />
                <v-card-text>
                    <v-list two-line>
                        <v-list-item two-line>
                            <v-list-item-avatar>
                                <v-icon color="primary">
                                    mdi-microsoft-teams
                                </v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    league.teams_count
                                }}</v-list-item-title>
                                <v-list-item-subtitle
                                    >Teams</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item two-line>
                            <v-list-item-avatar>
                                <v-icon color="primary"> mdi-sync </v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    league.weeks
                                }}</v-list-item-title>
                                <v-list-item-subtitle
                                    >Weeks</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item two-line>
                            <v-list-item-avatar>
                                <v-icon color="primary">
                                    mdi-calendar-text-outline
                                </v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>2021/2022</v-list-item-title>
                                <v-list-item-subtitle
                                    >Season</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        text
                        color="primary"
                        :loading="simulateProgress"
                        @click="simulate"
                    >
                        Simulate all
                    </v-btn>
                    <v-btn
                        text
                        :loading="simulateWeekProgress"
                        @click="simulateWeek"
                    >
                        Simulate this week
                    </v-btn>
                    <v-btn
                        text
                        color="error"
                        :loading="resetProgress"
                        @click="reset"
                    >
                        Reset
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "LeagueInfoCard",
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
            simulateProgress: false,
            simulateWeekProgress: false,
            resetProgress: false,
        };
    },
    methods: {
        async simulate() {
            this.simulateProgress = true;
            await this.$axios.post(`leagues/${this.league.id}/simulate`);
            this.simulateProgress = false;
            this.$emit("simulated");
        },
        async simulateWeek() {
            this.simulateWeekProgress = true;
            await this.$axios.post(`leagues/${this.league.id}/simulate/week`, {
                week: this.week,
            });
            this.simulateWeekProgress = false;
            this.$emit("weekSimulated");
        },
        async reset() {
            this.resetProgress = true;
            await this.$axios.post(`leagues/${this.league.id}/reset`);
            this.resetProgress = false;
            this.$emit("reset");
        },
    },
};
</script>
