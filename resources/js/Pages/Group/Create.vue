<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('groups.store'));
};
</script>

<template>
    <v-app>
        <Head title="Create Group" />
        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        Create Group
                    </v-toolbar-title>
                </v-toolbar>
            </template>
            <v-main>
                <v-container class="py-12">
                    <v-row justify="center">
                        <v-col cols="12" md="8">
                            <v-card class="elevation-3">
                                <v-card-title>
                                    <span class="text-h6">Group Information</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-form @submit.prevent="submit">
                                        <v-text-field
                                            v-model="form.name"
                                            label="Group Name"
                                            required
                                            outlined
                                            dense
                                        ></v-text-field>
                                        <v-row justify="end">
                                            <v-col cols="auto">
                                                <v-btn type="submit" color="primary" class="ma-2" elevation="2">
                                                    <v-icon left>mdi-plus</v-icon>
                                                    Create Group
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>