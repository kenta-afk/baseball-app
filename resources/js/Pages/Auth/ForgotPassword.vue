<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <v-container>
        <Head title="Forgot Password" />

        <div class="mb-4 text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <v-alert v-if="status" type="success" class="mb-4">
            {{ status }}
        </v-alert>

        <v-form @submit.prevent="submit">
            <v-text-field
                label="Email"
                type="email"
                v-model="form.email"
                :error-messages="form.errors.email"
                required
                autofocus
            />
            <v-btn
                color="primary"
                :loading="form.processing"
                :disabled="form.processing"
                @click="submit"
            >
                Email Password Reset Link
            </v-btn>
        </v-form>
    </v-container>
</template>
