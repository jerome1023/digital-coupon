<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import StoreForm from "@/Views/Store/Form.vue";
import { TPageDetails, TPageProps } from "@/Types/type";
import { useToast } from "primevue/usetoast";

const toast = useToast();

const { owners } = usePage().props as TPageProps;

const page = <TPageDetails>{
    pageTitle: "Add Store",
    formTitle: "Store Information",
    path: "store.index",
};

const form = useForm({
    owner_id: "",
    name: "",
    address: "",
});

const submit = () => {
    form.post(route("store.store", { preserveScroll: true }), {
        onSuccess: () => {
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Store added successfully",
                life: 3000,
            });
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <StoreForm :form="form" :page="page" :options="owners.data" />
    </form>
</template>
