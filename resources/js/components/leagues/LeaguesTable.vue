<template>
    <div class="mb-3">
        <div class="title mb-4">Leagues</div>
        <v-data-table
            :headers="headers"
            :items="items"
            :options.sync="paginatorOptions"
            :footer-props="footerProps"
            :server-items-length="totalItems"
            :loading="itemsLoading"
            loading-text="Loading..."
        >
            <template #item.title="{ item }">
                <router-link
                    :to="{ name: 'leagueHome', params: { id: item.id } }"
                >
                    {{ item.title }}
                </router-link>
            </template>
            <template #item.actions>
                <v-icon small class="mr-2"> mdi-pencil </v-icon>
                <v-icon small color="red"> mdi-delete </v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import editableTableData from "../../mixins/editableTableData";
import serverSidePagination from "../../mixins/serverSidePagination";

export default {
    mixins: [editableTableData, serverSidePagination],
    data: () => ({
        resource: "leagues",
        headers: [
            {
                text: "Title",
                sortable: false,
                align: "start",
                value: "title",
            },
            { value: "actions", sortable: false, align: "end", width: 110 },
        ],
    }),
};
</script>
