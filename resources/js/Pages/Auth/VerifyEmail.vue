<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <v-container>
        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <v-alert v-if="verificationLinkSent" type="success" class="mb-4">
            A new verification link has been sent to the email address you provided during registration.
        </v-alert>

        <v-form @submit.prevent="submit">
            <div class="d-flex justify-between align-center">
                <v-btn :loading="form.processing" color="primary" type="submit">
                    Resend Verification Email
                </v-btn>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-600 underline hover:text-gray-900"
                >
                    Log Out
                </Link>
            </div>
        </v-form>
    </v-container>
</template>
