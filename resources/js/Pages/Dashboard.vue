<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, computed } from 'vue';
import { VDataTable, VBtn, VContainer, VRow, VCol, VCard, VCardTitle, VCardText, VCardActions, VIcon, VDialog, VToolbar, VToolbarTitle, VSpacer, VBadge } from 'vuetify/components';

const props = defineProps({
    joinRequests: Array,
    userStats: Array, // ユーザーのスタッツを受け取る
});

const approveJoin = (id) => {
    Inertia.post(route('groups.approveJoin', id));
};

const dialog = ref(false);

// スタッツの合計を計算
const totalStats = computed(() => {
    const total = {
        at_bats: 0,
        hits: 0,
        pitches: 0,
        walks: 0,
        batting_average: 0,
    };

    let validBattingAverageCount = 0;

    console.log('User Stats:', props.userStats); // デバッグ出力

    props.userStats.forEach(stat => {
        total.at_bats += stat.at_bats || 0;
        total.hits += stat.hits || 0;
        total.pitches += stat.pitches || 0;
        total.walks += stat.walks || 0;
        const battingAverage = parseFloat(stat.batting_average);
        if (!isNaN(battingAverage)) {
            total.batting_average += battingAverage;
            validBattingAverageCount++;
        }
    });

    console.log('Total Batting Average Sum:', total.batting_average);
    console.log('Valid Batting Average Count:', validBattingAverageCount);

    if (validBattingAverageCount > 0) {
        total.batting_average = total.batting_average / validBattingAverageCount;
    } else {
        total.batting_average = 0;
    }

    console.log('Final Batting Average:', total.batting_average);

    return total;
});
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
                    <v-spacer></v-spacer>
                    <v-btn icon @click="dialog = true">
                        <v-icon>mdi-email</v-icon>
                        <v-badge v-if="props.joinRequests.length > 0" color="red" content="!"></v-badge>
                    </v-btn>
                </v-toolbar>
            </template>
            <v-main>
                <v-container class="py-12">
                    <v-row justify="center">
                        <v-col cols="12" md="8">
                            <v-card class="elevation-3 mb-4">
                                <v-card-title>
                                    <span class="text-h6">Total Stats</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-row>
                                        <v-col cols="6" md="4">At Bats: {{ totalStats.at_bats }}</v-col>
                                        <v-col cols="6" md="4">Hits: {{ totalStats.hits }}</v-col>
                                        <v-col cols="6" md="4">Pitches: {{ totalStats.pitches }}</v-col>
                                        <v-col cols="6" md="4">Walks: {{ totalStats.walks }}</v-col>
                                        <v-col cols="6" md="4">Batting Average: {{ totalStats.batting_average.toFixed(3) }}</v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-card class="elevation-3">
                                <v-card-title>
                                    <span class="text-h6">User Stats</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-data-table
                                        :headers="[
                                            { text: 'Date', value: 'date' },
                                            { text: 'Opponent', value: 'opponent' },
                                            { text: 'At Bats', value: 'at_bats' },
                                            { text: 'Hits', value: 'hits' },
                                            { text: 'Pitches', value: 'pitches' },
                                            { text: 'Walks', value: 'walks' },
                                            { text: 'Batting Average', value: 'batting_average' },
                                        ]"
                                        :items="props.userStats"
                                        class="elevation-1"
                                    ></v-data-table>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </AuthenticatedLayout>

        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
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
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="dialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<style scoped>
/* 必要に応じてスタイルを追加 */
</style>
