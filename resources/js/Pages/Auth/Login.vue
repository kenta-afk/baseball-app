<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

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
            <v-text-field
                label="Password"
                type="password"
                v-model="form.password"
                :error-messages="form.errors.password"
                required
            />

            <v-checkbox
                v-model="form.remember"
                label="Remember me"
            />

            <div class="mt-4 d-flex justify-end">
                <v-btn
                    text
                    v-if="canResetPassword"
                    :href="route('password.request')"
                >
                    Forgot your password?
                </v-btn>

                <v-btn
                    color="primary"
                    :loading="form.processing"
                    :disabled="form.processing"
                    @click="submit"
                >
                    Log in
                </v-btn>
            </div>
        </v-form>
    </GuestLayout>
</template>
