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
        <v-main class="d-flex align-center justify-center background-image" style="min-height: 100vh;">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="6">
                        <div class="text-h4 mb-6 card-content left-aligned-text">
                            Trajectory of baseball players
                        </div>
                        <v-row justify="center" class="mt-4 card-content">
                            <v-col v-if="canLogin" cols="auto">
                                <v-btn :href="route('login')" variant="outlined">
                                    <v-icon>mdi-login</v-icon>
                                    <span>Login</span>
                                </v-btn>
                            </v-col>
                            <v-col v-if="canRegister" cols="auto">
                                <v-btn :href="route('register')" variant="outlined">
                                    <v-icon>mdi-account-plus</v-icon>
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
.background-image {
    background-image: url('../../../public/build/assets/toppage.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.background-image::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.5);
    z-index: 1;
}

.card-content {
    position: relative;
    z-index: 2;
    color: black;
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
