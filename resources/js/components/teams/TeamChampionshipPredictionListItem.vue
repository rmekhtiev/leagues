<template>
    <v-row no-gutters class="black--text">
        <v-col cols="5">{{ prediction.team.title }}</v-col>
        <v-spacer />
        <v-col cols="5" class="text-right">% {{ prediction.percent }}</v-col>
    </v-row>
</template>

<script>
export default {
    name: "TeamChampionshipPredictionListItem",
    props: {
        prediction: {
            type: Object,
            required: true,
            default: () => ({}),
        },
    },
};
</script>

<style scoped></style>
