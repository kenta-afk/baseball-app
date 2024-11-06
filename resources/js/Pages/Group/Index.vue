<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import { VDataTable, VTextField, VPagination, VBtn, VContainer, VRow, VCol, VIcon } from 'vuetify/components';

const props = defineProps({
    groups: Object,
    filters: Object,
    userGroups: Array, // ユーザーが参加しているグループのIDリスト
    auth: Object, // 認証情報を追加
});

const search = ref(props.filters.search || '');

const performSearch = () => {
    Inertia.get(route('groups.index'), { search: search.value }, { preserveState: true, replace: true });
};

const goToShow = (id) => {
    Inertia.visit(route('groups.show', id));
};

function goToCreate() {
    Inertia.visit(route('groups.create'));
}

const isUserInGroup = (groupId) => {
    return props.userGroups.includes(groupId);
};

const isAdmin = (group) => {
    return group.admin_id === props.auth.user.id;
};

const deleteGroup = (groupId) => {
    if (confirm('Are you sure you want to delete this group?')) {
        Inertia.delete(route('groups.destroy', groupId));
    }
};
</script>

<template>
    <v-app>
        <Head title="Groups" />

        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        Groups
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn @click="goToCreate" color="primary" class="ma-2" elevation="2">
                        <v-icon left>mdi-plus</v-icon>
                        Create Group
                    </v-btn>
                </v-toolbar>
            </template>

            <v-container>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="search"
                            label="Search Groups"
                            single-line
                            hide-details
                        >
                            <template #append>
                                <v-btn icon @click="performSearch">
                                    <v-icon>mdi-magnify</v-icon>
                                </v-btn>
                            </template>
                        </v-text-field>
                    </v-col>
                </v-row>

                <v-data-table
                    :headers="[
                        { text: 'Name', value: 'name' },
                        { text: 'Actions', value: 'actions', sortable: false },
                    ]"
                    :items="props.groups.data"
                    :items-per-page="10"
                    class="elevation-1"
                >
                    <template #item.actions="{ item }">
                        <v-btn
                            v-if="isUserInGroup(item.id)"
                            @click="goToShow(item.id)"
                            color="primary"
                            class="ma-2"
                            elevation="2"
                        >
                            <v-icon left>mdi-eye</v-icon>
                            Details
                        </v-btn>
                        <v-btn
                            v-if="isAdmin(item)"
                            @click="deleteGroup(item.id)"
                            color="red"
                            class="ma-2"
                            elevation="2"
                        >
                            <v-icon left>mdi-delete</v-icon>
                            Delete
                        </v-btn>
                    </template>
                </v-data-table>

                <v-pagination
                    v-model="props.groups.current_page"
                    :length="props.groups.last_page"
                    @input="page => Inertia.get(route('groups.index'), { page }, { preserveState: true, replace: true })"
                ></v-pagination>
            </v-container>
        </AuthenticatedLayout>
    </v-app>
</template>

<style scoped>
/* 必要に応じてスタイルを追加 */
</style>
