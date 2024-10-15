<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <v-app>
        <Head title="Groups" />

        <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Groups
            </h2>
        </template>
        </AuthenticatedLayout>
    </v-app>

</template>