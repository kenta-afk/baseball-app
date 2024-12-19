<template>
    <v-app>
        <Head :title="`Edit Stats for ${user.name}`" />
        <AuthenticatedLayout>
            <template #header>
                <v-toolbar flat color="white">
                    <v-toolbar-title class="text-xl font-semibold leading-tight text-gray-800">
                        Edit Stats for {{ user.name }}
                    </v-toolbar-title>
                </v-toolbar>
            </template>
            <v-main>
                <v-container class="py-12">
                    <v-row justify="center">
                        <v-col cols="12" md="8">
                            <v-form @submit.prevent="submit">
                                <v-text-field v-model="form.date" label="Date" type="date" required />
                                <v-text-field v-model="form.opponent" label="Opponent" required />
                                <v-text-field v-model="form.at_bats" label="打数" type="number" required />
                                <v-text-field v-model="form.hits" label="安打" type="number" required />
                                <v-text-field v-model="form.pitches" label="投球数" type="number" required />
                                <v-text-field v-model="form.walks" label="四球" type="number" required />
                                <v-text-field v-model="form.batting_average" label="打率" type="number" step="0.001" required />
                                <input type="hidden" v-model="form.group_id" /> <!-- group_idを隠しフィールドとして追加 -->
                                <v-btn type="submit" color="primary" class="ma-2" elevation="2">
                                    Save
                                </v-btn>
                            </v-form>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    user: Object,
    stats: Object, // statsをpropsとして受け取る
    group_id: [Number, String], // group_idをNumberまたはStringとして受け取る
});

const form = ref({
    date: props.stats ? props.stats.date : '',
    opponent: props.stats ? props.stats.opponent : '',
    at_bats: props.stats ? props.stats.at_bats : 0,
    hits: props.stats ? props.stats.hits : 0,
    pitches: props.stats ? props.stats.pitches : 0,
    walks: props.stats ? props.stats.walks : 0,
    batting_average: props.stats ? props.stats.batting_average : 0,
    group_id: Number(props.group_id), // group_idを数値に変換
});

const submit = () => {
    Inertia.post(route('user.stats.update', props.user.id), form.value);
};
</script>

<style scoped>
/* 必要に応じてスタイルを追加 */
</style>