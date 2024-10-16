<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <v-container>
        <Head title="Register" />

        <v-form @submit.prevent="submit">
            <v-text-field
                v-model="form.name"
                label="Name"
                required
                autofocus
                outlined
                :error-messages="form.errors.name"
            ></v-text-field>

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
                <Link
                    :href="route('login')"
                    class="me-4 text-sm text-gray-600 underline hover:text-gray-900"
                >
                    Already registered?
                </Link>

                <v-btn :loading="form.processing" color="primary" type="submit">
                    Register
                </v-btn>
            </div>
        </v-form>
    </v-container>
</template>
