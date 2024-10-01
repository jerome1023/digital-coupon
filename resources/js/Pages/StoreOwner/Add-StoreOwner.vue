<script setup lang="ts">
import FormContainer from "@/Components/FormContainer.vue";
import { useForm } from "@inertiajs/vue3";
import RegisterForm from "@/Views/Register/Form.vue";
import { TPageDetails } from "@/Types/type";
import { useToast } from "primevue/usetoast";

const toast = useToast();

const page = <TPageDetails>{
    pageTitle: "Add Store Owner",
    formTitle: "Store Owner Information",
    path: "owner.index",
};

const form = useForm({
    first_name: "",
    last_name: "",
    role: "store_owner",
    username: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
  form.post(route('owner.store'), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Owner added successfully",
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
