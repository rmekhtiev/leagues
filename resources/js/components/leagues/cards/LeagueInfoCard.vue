<template>
    <v-card class="py-2" flat>
        <v-card-text class="pb-0">
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
                                        <v-icon color="primary">
                                            mdi-calendar-text-outline
                                        </v-icon>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title
                                            >2021/2022</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Season</v-list-item-subtitle
                                        >
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
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
    },
};
</script>
