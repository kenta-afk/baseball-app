<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';  // Inertiaをインポート

function goToCreate() {
    Inertia.visit(route('groups.create'));  // routeヘルパーでURL生成
}
</script>

<template>
    <v-app>

        <Head title="Groups" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Groups
                </h2>

                <div>
                    <v-btn @click="goToCreate">Create Group</v-btn>
                </div>
            </template>
        </AuthenticatedLayout>
    </v-app>
</template>
