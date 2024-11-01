<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { VDataTable, VContainer, VRow, VCol, VCard, VCardTitle, VCardText } from 'vuetify/components';

const props = defineProps({
    group: Object,
    users: Array,
});
</script>

<template>
    <v-app>
        <Head title="Group Details" />
        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        {{ group.name }} - Details
                    </v-toolbar-title>
                </v-toolbar>
            </template>
            <v-main>
                <v-container class="py-12">
                    <v-row justify="center">
                        <v-col cols="12" md="8">
                            <v-card class="elevation-3">
                                <v-card-title>
                                    <span class="text-h6">Members</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="[
                                            { text: 'Name', value: 'name' },
                                        ]"
                                        :items="users"
                                        class="elevation-1"
                                    ></v-data-table>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>