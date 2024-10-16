<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-4 text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <v-form @submit.prevent="submit">
            <v-text-field
                label="Password"
                type="password"
                v-model="form.password"
                :error-messages="form.errors.password"
                required
                autofocus
            />
            <v-btn
                color="primary"
                :loading="form.processing"
                :disabled="form.processing"
                @click="submit"
            >
                Confirm
            </v-btn>
        </v-form>
    </GuestLayout>
</template>
