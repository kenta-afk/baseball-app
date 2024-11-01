<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { VDataTable, VTextField, VPagination, VContainer, VRow, VCol, VBtn, VIcon } from 'vuetify/components';

const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

const performSearch = () => {
    Inertia.get(route('users.index'), { search: search.value }, { preserveState: true, replace: true });
};
</script>

<template>
    <v-app>
        <Head title="Users" />

        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        Users
                    </v-toolbar-title>
                </v-toolbar>
            </template>

            <v-container>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="search"
                            label="Search Users"
                            single-line
                            hide-details
                            outlined
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
                    ]"
                    :items="props.users.data"
                    :items-per-page="10"
                    class="elevation-1"
                ></v-data-table>

                <v-pagination
                    v-model="props.users.current_page"
                    :length="props.users.last_page"
                    @input="page => Inertia.get(route('users.index'), { page }, { preserveState: true, replace: true })"
                ></v-pagination>
            </v-container>
        </AuthenticatedLayout>
    </v-app>
</template>