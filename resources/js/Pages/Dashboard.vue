<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { VDataTable, VBtn, VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VCardActions, VIcon } from 'vuetify/components';

const props = defineProps({
    joinRequests: Array,
});

const approveJoin = (id) => {
    Inertia.post(route('groups.approveJoin', id));
};
</script>

<template>
    <v-app>
        <Head title="MyPage" />
        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        MyPage
                    </v-toolbar-title>
                </v-toolbar>
            </template>
            <v-main>
                <v-container class="py-12">
                    <v-row justify="center">
                        <v-col cols="12" md="8">
                            <v-card class="mb-4">
                                <v-card-title>
                                    Join Requests
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="[
                                            { text: 'User', value: 'user.name' },
                                            { text: 'Group', value: 'group.name' },
                                            { text: 'Actions', value: 'actions', sortable: false },
                                        ]"
                                        :items="props.joinRequests"
                                        class="elevation-1"
                                    >
                                        <template #item.actions="{ item }">
                                            <v-btn @click="approveJoin(item.id)" color="primary" class="ma-2" elevation="2">
                                                <v-icon left>mdi-check</v-icon>
                                                Approve
                                            </v-btn>
                                        </template>
                                    </v-data-table>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>
