<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia'; // Inertiaをインポート
import { VDataTable, VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VBtn, VIcon } from 'vuetify/components';

const props = defineProps({
    group: Object,
    users: Array,
    isAdmin: Boolean, // 管理者かどうかのフラグ
});

const goToEditStats = (userId) => {
    Inertia.visit(route('user.stats.edit', { user: userId, group: props.group.id }));
};

const removeUser = (userId) => {
    if (confirm('Are you sure you want to remove this user from the group?')) {
        Inertia.delete(route('groups.removeUser', { group: props.group.id, user: userId }));
    }
};
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
                                            { text: 'Actions', value: 'actions', sortable: false },
                                        ]"
                                        :items="users"
                                        class="elevation-1"
                                    >
                                        <template #item.name="{ item }">
                                            <span>
                                                {{ item.name }}
                                                <v-icon v-if="item.id === group.admin_id" color="primary" class="ml-2">mdi-crown</v-icon>
                                            </span>
                                        </template>
                                        <template #item.actions="{ item }">
                                            <v-btn
                                                v-if="isAdmin && item.id !== group.admin_id"
                                                @click="goToEditStats(item.id)"
                                                color="primary"
                                                class="ma-2"
                                                elevation="2"
                                            >
                                                <v-icon left>mdi-pencil</v-icon>
                                                Edit
                                            </v-btn>
                                            <v-btn
                                                v-if="isAdmin && item.id !== group.admin_id"
                                                @click="removeUser(item.id)"
                                                color="red"
                                                class="ma-2"
                                                elevation="2"
                                            >
                                                <v-icon left>mdi-delete</v-icon>
                                                Remove
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