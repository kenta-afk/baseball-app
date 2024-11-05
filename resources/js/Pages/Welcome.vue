<script setup>
import { Head } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'

const theme = useTheme()

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <v-app>
        <Head title="Login and Register" />
        <v-main class="d-flex align-center justify-center background-gradient" style="min-height: 100vh;">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="6">
                        <div class="text-h4 mb-6 card-content text-center">
                            Trajectory of Baseball Players
                        </div>
                        <v-row justify="center" class="mt-4 card-content">
                            <v-col v-if="canLogin" cols="auto">
                                <v-btn :href="route('login')" variant="outlined" class="mx-2">
                                    <v-icon left>mdi-login</v-icon>
                                    <span>Login</span>
                                </v-btn>
                            </v-col>
                            <v-col v-if="canRegister" cols="auto">
                                <v-btn :href="route('register')" variant="outlined" class="mx-2">
                                    <v-icon left>mdi-account-plus</v-icon>
                                    <span>Register</span>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
.background-gradient {
    background: linear-gradient(135deg, #000000 0%, #ffffff 100%);
    animation: gradientShift 10s ease infinite;
    position: relative;
    overflow: hidden;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.card-content {
    position: relative;
    z-index: 2;
    color: white; /* テキストの色を白に変更 */
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); /* テキストに影を追加 */
}

.text-center {
    text-align: center;
}

.left-aligned-text {
    position: absolute;
    top: 40px; /* 上からの距離 */
    left: 50px; /* 左からの距離 */
    z-index: 2;
    color: black; /* テキストの色 */
}

.animated-text {
    white-space: nowrap;
    overflow: hidden;
    position: relative;
    animation: moveText 15s linear infinite;
}

@keyframes moveText {
    0% {
        transform: translateX(200%);
    }
    100% {
        transform: translateX(-200%);
    }
}
</style>
