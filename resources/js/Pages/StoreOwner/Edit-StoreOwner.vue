<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import RegisterForm from "@/Views/Register/Form.vue";
import { TPageDetails, TPageProps } from "@/Types/type";
import { useToast } from "primevue/usetoast";

const toast = useToast();

const { owner } = usePage().props as TPageProps

const page = <TPageDetails>{
    pageTitle: "Edit Store Owner",
    formTitle: "Store Owner Information",
    path: "owner.index",
};

const form = useForm({
    first_name: owner.data.first_name || "",
    last_name: owner.data.last_name || "",
    username: owner.data.username || "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    const id = owner.data.id;
    form.put(route("owner.update", id), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Owner updated successfully",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <FormContainer :form="form" :page="page">
            <RegisterForm :form="form" />
        </FormContainer>
    </form>
</template>
