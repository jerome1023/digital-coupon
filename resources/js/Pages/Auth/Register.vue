<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormGroup from '@/Components/FormGroup.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    role: 'customer',
    username: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register',{
        preserveScroll: false,
    }));
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <FormGroup type="text" name="first_name" label="Firstname" :form="form"/>
            <FormGroup type="text" name="last_name" label="Lastname" :form="form"/>
            <FormGroup type="text" name="username" label="Username" :form="form"/>
            <FormGroup type="password" name="password" label="Password" :form="form"/>
            <FormGroup type="password" name="password_confirmation" label="Confirm Password" :form="form"/>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
