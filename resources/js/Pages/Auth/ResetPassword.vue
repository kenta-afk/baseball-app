<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <v-container>
        <Head title="Reset Password" />

        <v-form @submit.prevent="submit">
            <v-text-field
                v-model="form.email"
                label="Email"
                type="email"
                required
                outlined
                :error-messages="form.errors.email"
            ></v-text-field>

            <v-text-field
                v-model="form.password"
                label="Password"
                type="password"
                required
                outlined
                :error-messages="form.errors.password"
            ></v-text-field>

            <v-text-field
                v-model="form.password_confirmation"
                label="Confirm Password"
                type="password"
                required
                outlined
                :error-messages="form.errors.password_confirmation"
            ></v-text-field>

            <div class="d-flex justify-end mt-4">
                <v-btn :loading="form.processing" color="primary" type="submit">
                    Reset Password
                </v-btn>
            </div>
        </v-form>
    </v-container>
</template>
